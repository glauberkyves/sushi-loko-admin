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
        $arrArquivo   = array();
        $pathArquivos = $this->getContainer()->getParameter('path_arquivo_retorno');

        # analisando pasta valida
        if (file_exists($pathArquivos)) {
            foreach (new \DirectoryIterator($pathArquivos) as $arquivo) {
                if (!$arquivo->isDot() && !$arquivo->isDir() && strtolower($arquivo->getExtension()) == 'txt') {
                    $dadosArquivo = $this->getDetailFile($arquivo->getFilename());
                    $file         = $pathArquivos . DIRECTORY_SEPARATOR . $arquivo->getFilename();

                    $entity = $this->newEntity();
                    $entity->setNoArquivo($arquivo->getFilename());
                    $entity->setNoBlobArquivo(file_get_contents($file));
                    $entity->setDtProcessamento(new \Datetime());

                    $this->persist($entity);
                    $this->saveTransacao($dadosArquivo + array('idArquivo' => $entity));

                    array_push($arrArquivo, $dadosArquivo);
                    unlink($file);
                }
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

        $idFranquia = $this->getService('service.franquia')->findOneByNuCodigoLoja($dadosArquivo['nuCodigoLoja']);
        $entity->setIdFranquia($idFranquia);

        $idUsuario = $this->getService('service.franqueador_usuario')->findUsuarioPorFranquia(
            $dadosArquivo['nuCpf'],
            $dadosArquivo['nuCodigoLoja']
        );
        $entity->setIdUsuario($idUsuario);

        $entity->setIdOperador(null);
        $entity->setIdArquivo($dadosArquivo['idArquivo']);

        $idTipoTransacao = $this->getService('service.tipo_transacao')->find(TipoTransacao::CREDITO);
        $entity->setIdTipoTransacao($idTipoTransacao);

        $entity->setNuValor(substr_replace($dadosArquivo['nuValor'], '.', strlen($dadosArquivo['nuValor']) - 3, 1));
        $entity->setDtCadastro(new \DateTime());
        $entity->setStAtivo(true);

        $this->persist($entity);
    }

    public function getDetailFile($filename)
    {
        $pathArquivos = $this->getContainer()->getParameter('path_arquivo_retorno');
        $filename     = str_replace('.txt', '', strtolower($filename));

        $file           = file($pathArquivos . DIRECTORY_SEPARATOR . $filename . '.txt');
        $nuCodigoLoja   = explode('|', $file[1]);
        $nuCodigoLoja   = (int)end($nuCodigoLoja);
        $dadosPagamento = explode('|', $file[7]);

        return array(
            'nuCpf'        => substr($filename, 0, 11),
            'nuValor'      => $dadosPagamento[1],
            'nuCodigoLoja' => $nuCodigoLoja
        );
    }
}