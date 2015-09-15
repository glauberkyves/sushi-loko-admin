<?php

namespace Super\EnqueteBundle\Service;

use Base\BaseBundle\Entity\TbTransacao;
use Base\CrudBundle\Service\CrudService;
use Super\TransacaoBundle\Service\TipoTransacao;

class EnqueteRespostaUsuario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbEnqueteRespostaUsuario';

    public function adicionar($idUsuario = null, $idEnquete = null, $idEnqueteResposta = null)
    {
        if($idUsuario && $idEnquete)
        {
            $resposta = $this->newEntity();
            $resposta->setIdUsuario($idUsuario);
            $resposta->setIdEnquete($idEnquete);
            $resposta->setIdEnqueteResposta($idEnqueteResposta ?: null);
            $resposta->setDtCadastro(new \DateTime());

            $this->persist($resposta);

            //caso tenha respondido, verificar a recompensa
            if($idEnqueteResposta) {
                $this->getService('service.bonus')->setBonus(
                    $idUsuario->getIdFranqueadorUsuario(),
                    $idEnquete->getNuPontos()
                );
                $this->creditar(TipoTransacao::CREDITO, $idEnquete->getNuBonus(), $idUsuario);
            }

            return $resposta;
        }
    }

    public function creditar($tipoTransacao = 0, $nuValor = 0, $idUsuario = null)
    {
        $idTipoTransacao = $this->getService('service.tipo_transacao')->find($tipoTransacao);

        if ($idTipoTransacao && ($nuValor > 0)) {
            $entity = new TbTransacao();
            $entity->setIdFranquia(null);
            $entity->setIdOperador(null);
            $entity->setIdArquivo(null);
            $entity->setIdUsuario($idUsuario);
            $entity->setIdTipoTransacao($idTipoTransacao);
            $entity->setNuValor(substr_replace($nuValor, '.', strlen($nuValor) - 3, 1));
            $entity->setDtCadastro(new \DateTime());
            $entity->setStAtivo(true);

            $this->persist($entity);
        }
    }
}