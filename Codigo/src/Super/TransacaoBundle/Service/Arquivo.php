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
        $arrArquivo        = array();
        $arrFranqueadorFTP = $this->getService('service.configuracao_ftp')->findAll();

        foreach ($arrFranqueadorFTP as $config) {
            try {
                $ftp = ftp_connect($config->getNoHost()) or new \Exception();
                $login = ftp_login($ftp, $config->getNoUsuario(), $config->getNoSenha()) or new \Exception();
                $contents = ftp_nlist($ftp, $config->getNoPasta()) or new \Exception();

                $dirFiles   = md5(microtime()) . DIRECTORY_SEPARATOR;
                $tempFolder = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $dirFiles . DIRECTORY_SEPARATOR;

                mkdir($tempFolder, 0777, true) or new \Exception();

                foreach ($contents as $key => $arquivoFTP) {
                    $pathFile = str_replace('\\', '/', $config->getNoPasta() . DIRECTORY_SEPARATOR . $arquivoFTP);
                    ftp_get($ftp, $tempFolder . $arquivoFTP, $pathFile, FTP_BINARY) or new \Exception();
                }

                foreach (new \DirectoryIterator($tempFolder) as $arquivo) {
                    if (!$arquivo->isDot() && !$arquivo->isDir() && strtolower(pathinfo($arquivo->getFilename(), PATHINFO_EXTENSION)) == 'txt') {
                        $dadosArquivo = $this->getDetailFile($tempFolder, $arquivo->getFilename());
                        $file         = $tempFolder . DIRECTORY_SEPARATOR . $arquivo->getFilename();

                        $entity = $this->newEntity();
                        $entity->setNoArquivo($arquivo->getFilename());
                        $entity->setNoBlobArquivo(file_get_contents($file));
                        $entity->setDtProcessamento(new \Datetime());

                        $this->persist($entity);

                        $dadosArquivo['idArquivo']     = $entity;
                        $dadosArquivo['idFranqueador'] = $config->getIdFranqueador()->getIdFranqueador();

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
            'idFranqueador' => $dadosArquivo['idFranqueador']
        );

        $idFranquia = $this->getService('service.franquia')->findOneBy($criteria);
        $entity->setIdFranquia($idFranquia);

        $idUsuario = $this->getService('service.franqueador_usuario')->findUsuarioPorFranquia(
            $dadosArquivo['nuCpf'],
            $dadosArquivo['nuCodigoLoja']
        );
        $entity->setIdUsuario($idUsuario);

        if (!$idUsuario) {
            return;
        }

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
        echo file_get_contents($path . DIRECTORY_SEPARATOR . $filename . '.txt');
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