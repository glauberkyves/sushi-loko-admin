<?php
namespace Super\TransacaoBundle\Service;

use Base\BaseBundle\Entity\TbTransacao;
use Base\BaseBundle\Service\Data;
use Base\CrudBundle\Service\CrudService;

class Arquivo extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbArquivo';

    public function processarArquivoRetorno()
    {
        ini_set('max_execution_time', 0);

        $arrArquivo        = array();
        $arrFranqueadorFTP = $this->getService('service.configuracao_ftp')->findAll();

        foreach ($arrFranqueadorFTP as $config) {
            try {
                $ftp = ftp_connect($config->getNoHost()) or new \Exception();
                $login = ftp_login($ftp, $config->getNoUsuario(), $config->getNoSenha()) or new \Exception();
                ftp_pasv($ftp, true);
                ftp_set_option($ftp, FTP_TIMEOUT_SEC, 1800);

                $contents = ftp_nlist($ftp, $config->getNoPasta()) or new \Exception();

                $tempFolder = sys_get_temp_dir() . DIRECTORY_SEPARATOR . md5(microtime()) . DIRECTORY_SEPARATOR;

                mkdir($tempFolder, 0777, true) or new \Exception();

                $total = 0;
                foreach ($contents as $key => $arquivoFTP) {
                    if (strtoupper(substr($arquivoFTP, strlen($arquivoFTP) - 3, 3)) == 'TXT' && $total <= 500) {
                        $pathFile = str_replace('\\', '/', $config->getNoPasta() . DIRECTORY_SEPARATOR . $arquivoFTP);
                        ftp_get($ftp, $tempFolder . $arquivoFTP, $pathFile, FTP_BINARY) or new \Exception();
                        clearstatcache();
                        $total++;
                    }
                }

                foreach (new \DirectoryIterator($tempFolder) as $arquivo) {
                    if (!$arquivo->isDot() && !$arquivo->isDir() && strtolower(pathinfo($arquivo->getFilename(), PATHINFO_EXTENSION)) == 'txt') {
                        $dadosArquivo = $this->getDetailFile($tempFolder, $arquivo->getFilename());
                        $file         = $tempFolder . $arquivo->getFilename();

                        $dadosArquivo['idFranqueador'] = $config->getIdFranqueador()->getIdFranqueador();

                        $entity = $this->newEntity();
                        $entity->setNoArquivo($arquivo->getFilename());
                        $entity->setNuValor($dadosArquivo['nuValor']);
                        $entity->setNoBlobArquivo(file_get_contents($file));
                        $entity->setDtProcessamento(new \Datetime());

                        $this->persist($entity);

                        $dadosArquivo['idArquivo'] = $entity;

                        $this->saveTransacao($dadosArquivo);

                        $pathFileFTP = str_replace('\\', '/', $config->getNoPasta() . DIRECTORY_SEPARATOR . $arquivo->getFilename());
                        ftp_delete($ftp, $pathFileFTP) or new \Exception();

                        array_push($arrArquivo, $dadosArquivo);
                        unlink($file);
                    }
                }

                rmdir($tempFolder) or new \Exception();
                ftp_close($ftp);

            } catch (\Exception $exp) {
                continue;
            }
        }

        return array(
            'status'   => count($arrArquivo) ? true : false,
            'menssage' => 'Total Arquivos processados: ' . count($arrArquivo)
        );
    }

    public function saveTransacao(array $dadosArquivo)
    {
        $entity = new TbTransacao();

        $criteria = array(
            'nuCodigoLoja'  => $dadosArquivo['nuCodigoLoja'],
//            'nuCodigoLoja'  => 30,
            'idFranqueador' => $dadosArquivo['idFranqueador']
        );

        $idFranquia = $this->getService('service.franquia')->findOneBy($criteria);
        $entity->setIdFranquia($idFranquia);

        if (!$idFranquia->getStAtivo()) {
            return;
        }

        $idUsuario = $this->getService('service.franqueador_usuario')->findUsuarioPorFranquia(
            $dadosArquivo['nuCpf'],
            $dadosArquivo['nuCodigoLoja']
        );

        if (!$idUsuario) {
//            $request = $this->getRequest();
//            $request->request->set('nuCpf', $dadosArquivo['nuCpf']);
//            $request->request->set('noSenha', '123456');
//            $request->request->set('noPessoa', 'Teste Arquivo');
//            $request->request->set('noEmail', 'testearquivo@testearquivo.com.br');
//            $request->request->set('sgSexo', 'm');
//            $request->request->set('nuCep', '12345678');
//
//            $idUsuario     = $this->getService('service.usuario')->save();
//            $idFranqueador = $idFranquia->getIdFranqueador();
//            $this->getService('service.franqueador_usuario')->saveFranqueadorUsuario($idFranqueador, $idUsuario);

            return;
        }

        $entity->setIdUsuario($idUsuario);
        $entity->setIdOperador(null);
        $entity->setIdArquivo($dadosArquivo['idArquivo']);

        $idTipoTransacao = $this->getService('service.tipo_transacao')->find(TipoTransacao::CREDITO);
        $entity->setIdTipoTransacao($idTipoTransacao);

        $criteria             = array(
            'idUsuario'     => $idUsuario,
            'idFranqueador' => $idFranquia->getIdFranqueador()
        );
        $idFranqueadorUsuario = $this->getService('service.franqueador_usuario')->findOneBy($criteria);

        $nuValorCreditar = $this->getService('service.transacao')->getNuValorCreditar(
            $idFranqueadorUsuario,
            str_replace(",", ".", str_replace(".", "", $dadosArquivo['nuValor']))
        );

        $entity->setNuValor($nuValorCreditar);
        $entity->setStAtivo(true);
        $entity->setDtCadastro(new \DateTime());

        $this->persist($entity);

        $nuBonusCreditar = $this->getService('service.bonus')->getBonusCreditar(
            $idFranqueadorUsuario,
            str_replace(",", ".", str_replace(".", "", $dadosArquivo['nuValor']))
        );

        $this->getService('service.bonus')->setBonus($idFranqueadorUsuario, $nuBonusCreditar);
    }

    public function getDetailFile($path, $filename)
    {
        $filename = str_replace('.txt', '', strtolower($filename));

        ob_start();
        var_dump(file_get_contents($path . DIRECTORY_SEPARATOR . $filename . '.TXT'));
        $file = ob_get_contents();
        ob_end_clean();

        $stringPagamento = trim(str_replace(
            array('[INICIO PAGAMENTO]', '[FIM PAGAMENTO]'),
            array('', ''),
            substr($file, strpos($file, '[INICIO PAGAMENTO]'), strpos($file, '[FIM PAGAMENTO]'))
        ));

        $stringCodigoLoja = trim(str_replace(
            array('[DATA HORA]', '[FIM DATA HORA]'),
            array('', ''),
            substr($file, strpos($file, '[DATA HORA]'), strpos($file, '[FIM DATA HORA]'))
        ));

        $nuCodigoLoja   = explode('|', $stringCodigoLoja);
        $nuCodigoLoja   = (int)end($nuCodigoLoja);
        $dadosPagamento = explode('|', $stringPagamento);

        return array(
            'nuCpf'        => substr($filename, 0, 11),
            'nuValor'      => $dadosPagamento[1],
            'nuCodigoLoja' => $nuCodigoLoja
        );
    }
}