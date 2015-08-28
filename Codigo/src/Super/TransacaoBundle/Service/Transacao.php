<?php
namespace Super\TransacaoBundle\Service;

use Base\BaseBundle\Entity\TbFranqueador;
use Base\BaseBundle\Entity\TbFranquia;
use Base\BaseBundle\Entity\TbRequisacaoTransacao;
use Base\BaseBundle\Entity\TbTransacao;
use Base\BaseBundle\Entity\TbUsuario;
use Base\CrudBundle\Service\CrudService;

class Transacao extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbTransacao';

    public function saque(TbUsuario $idUsuario, TbFranquia $idFranquia, $nuValor)
    {
        $totalCredito = $this->getCreditosUsuario(
            $idUsuario->getIdUsuario(),
            $idFranquia->getIdFranqueador()->getIdFranqueador()
        );

        if ($nuValor > $totalCredito) {
            throw new \Exception('Valor a ser utilizado é maior do que total de créditos.');
        }

        $entity = new TbTransacao();
        $entity->setIdFranquia($idFranquia);
        $entity->setIdUsuario($idUsuario);

        $entity->setIdOperador($this->getUser());
        $entity->setIdArquivo(null);

        $idTipoTransacao = $this->getService('service.tipo_transacao')->find(TipoTransacao::DEBITO);
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
}