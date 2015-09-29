<?php
namespace Super\TransacaoBundle\Service;

use Base\BaseBundle\Entity\TbFranqueador;
use Base\BaseBundle\Entity\TbFranqueadorUsuario;
use Base\BaseBundle\Entity\TbFranquia;
use Base\BaseBundle\Entity\TbRequisacaoTransacao;
use Base\BaseBundle\Entity\TbTransacao;
use Base\BaseBundle\Entity\TbTransacaoJustificativa;
use Base\BaseBundle\Entity\TbUsuario;
use Base\CrudBundle\Service\CrudService;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class Transacao extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbTransacao';

    public function saque(TbUsuario $idUsuario, TbFranquia $idFranquia, $requisicaoTransacao = null)
    {
        $nuValor         = $requisicaoTransacao->getNuValor();
        $totalCredito    = $this->getCreditosUsuario(
            $idUsuario->getIdUsuario(),
            $idFranquia->getIdFranqueador()->getIdFranqueador()
        );
        $idTipoTransacao = $this->getService('service.tipo_transacao')->find(TipoTransacao::DEBITO);

        if ($nuValor > $totalCredito) {
            throw new \Exception('Valor a ser utilizado é maior do que total de créditos.');
        }

        $entity = new TbTransacao();

        $entity->setIdFranquia($idFranquia);
        $entity->setIdUsuario($idUsuario);
        $entity->setIdRequisacaoTransacao($requisicaoTransacao);
        $entity->setIdOperador($this->getUser());
        $entity->setIdArquivo(null);
        $entity->setIdTipoTransacao($idTipoTransacao);
        $entity->setNuValor(substr_replace($nuValor, '.', strlen($nuValor) - 3, 1));
        $entity->setDtCadastro(new \DateTime());
        $entity->setStAtivo(true);

        try {
            $this->persist($entity);
        } catch (\Exception $exp) {
            throw new \Exception('Erro ao utilizar créditos.');
        }
    }

    public function setCredito(TbUsuario $idUsuario, TbFranqueador $idFranqueador, $nuValor = 0)
    {
        $transacao = new TbTransacao();
        $transacao->setIdFranqueador($idFranqueador);
        $transacao->setIdUsuario($idUsuario);

        $transacao->setIdOperador(null);
        $transacao->setIdArquivo(null);

        $idTipoTransacao = $this->getService('service.tipo_transacao')->find(TipoTransacao::CREDITO);
        $transacao->setIdTipoTransacao($idTipoTransacao);

        $transacao->setNuValor($nuValor);
        $transacao->setDtCadastro(new \DateTime());
        $transacao->setStAtivo(true);

        try {
            $this->persist($transacao);

        } catch (\Exception $exp) {
            throw new \Exception('Erro ao inserir créditos.');
        }
    }

    public function requisicaoTransacaoUsuario(TbUsuario $idUsuario, TbFranqueador $idFranqueador, $nuValor = 0)
    {
        $criteria = array(
            'idUsuario'     => $idUsuario,
            'idFranqueador' => $idFranqueador,
            'stAtivo'       => true,
            'stUtilizado'   => false,
        );

        $requisacaoNaoUtilizada = $this->getService('service.requisicao_transacao')->findOneBy($criteria);

        if ($requisacaoNaoUtilizada) {
            $requisacaoNaoUtilizada->setStAtivo(false);

            $this->persist($requisacaoNaoUtilizada);
        }

        $entity = new TbRequisacaoTransacao();
        $entity->setIdUsuario($idUsuario);
        $entity->setIdFranqueador($idFranqueador);
        $entity->setNuValor($nuValor);
        $entity->setStUtilizado(false);
        $entity->setStAtivo(true);
        $entity->setDtCadastro(new \DateTime());
        $entity->setNoSenha($this->getService('service.usuario')->getRandomHash(4));

        try {
            $this->persist($entity);

            return $entity->getNoSenha();

        } catch (\Exception $exp) {
            throw new \Exception('Erro ao solicitar créditos.');
        }
    }

    public function saveTransacaoJustificativa($idTransacao, $stAtivo, $dsJustificativa = '')
    {
        $entityTransacao = $this->find($idTransacao);
        $entityTransacao->setStAtivo($stAtivo);

        $this->persist($entityTransacao);

        $entityJustificativa = new TbTransacaoJustificativa();
        $entityJustificativa->setIdTransacao($entityTransacao);
        $entityJustificativa->setIdUsuario($this->getUser());
        $entityJustificativa->setDsJustificativa($dsJustificativa);
        $entityJustificativa->setDtCadastro(new \DateTime());

        $this->persist($entityJustificativa);
    }

    public function isValidResgate($idFranqueador, $idUsuario, $nuValor = 0)
    {
        $franqueadorUsuario = $this->getService('service.franqueador_usuario')->findOneBy(array(
            'idUsuario'     => $idUsuario,
            'idFranqueador' => $idFranqueador
        ));

        if (!$franqueadorUsuario) {
            return false;
        }

        return $nuValor >= $franqueadorUsuario
            ->getIdFranqueador()
            ->getNuValorMinimoResgate() ? true : false;
    }

    public function getNuValorCreditar(TbFranqueadorUsuario $idFranqueadorUsuario, $nuValor = 0.0)
    {
        $valor = ($nuValor / 100) * $idFranqueadorUsuario->getIdFranqueador()->getNuPorcentagemBonusTransacao();

        if ($idFranqueadorUsuario->getIdFranqueador()->getStNiveis()) {
            $valor = $this->getService('service.bonus')->getPontosExtra($idFranqueadorUsuario, $nuValor);
        }

        return $valor;
    }

    public function excelTransacao(array $data, $franquia = false)
    {
        $date     = date("d-m-Y_H-i-s");
        $filename = "usuarios_" . $date . ".xls";

        $phpExcelObject = $this->getContainer()->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Usuário')
            ->setCellValue('B1', 'CPF')
            ->setCellValue('C1', 'Valor')
            ->setCellValue('D1', 'Data')
            ->setCellValue('E1', 'Tipo Transação')
            ->setCellValue('F1', 'Situação');
        $phpExcelObject->setActiveSheetIndex(0);

        if ($franquia) {
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('G1', 'Franquia');
        }

        foreach ($data as $key => $value) {
            $cell = $key + 2;
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue("A{$cell}", $value['noPessoa'])
                ->setCellValue("B{$cell}", $value['nuCpf'])
                ->setCellValue("C{$cell}", $value['nuValor'])
                ->setCellValue("D{$cell}", $value['dtCadastro'])
                ->setCellValue("E{$cell}", $value['noTipoTransacao'])
                ->setCellValue("F{$cell}", $value['stAtivo']);

            if ($franquia) {
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue("G{$cell}", $value['noFranquia']);
            }
        }

        $writer = $this->getContainer()->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->getContainer()->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}