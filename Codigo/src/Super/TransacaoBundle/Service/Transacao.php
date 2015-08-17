<?php
namespace Super\TransacaoBundle\Service;

use Base\BaseBundle\Entity\TbTransacao;
use Base\BaseBundle\Service\Data;
use Base\CrudBundle\Service\CrudService;

class Transacao extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbTransacao';

    public function getCreditosUsuario($nuCpf, $idFranqueador)
    {
        return $this->getRepository()->getCreditosUsuario($nuCpf, $idFranqueador);
    }

    public function saque($nuCpf, $nuCodigoLoja, $nuValor)
    {
        $totalCredito = $this->getCreditosUsuario(
            $nuCpf,
            $this->getUser()->getIdFranquiaOperador()->getIdFranquia()->getIdFranqueador()->getIdFranqueador()
        );

        if ($nuValor > $totalCredito) {
            throw new \Exception('Valor a ser utilizado é maior do que total de créditos.');
        }

        $entity = new TbTransacao();

        $idFranquia = $this->getService('service.franquia')->findOneByNuCodigoLoja($nuCodigoLoja);
        $entity->setIdFranquia($idFranquia);

        $idUsuario = $this->getService('service.franqueador_usuario')->findUsuarioPorFranquia(
            $nuCpf,
            $nuCodigoLoja
        );
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

    /**
     * @todo implementar
     * @param $nuCpf
     * @param $nuCodigoLoja
     * @param $noSenha
     * @return bool
     */
    public function verificarSenhaApp($nuCpf, $nuCodigoLoja, $noSenha)
    {
        return true;
    }
}