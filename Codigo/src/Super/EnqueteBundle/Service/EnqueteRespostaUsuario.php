<?php

namespace Super\EnqueteBundle\Service;

use Base\CrudBundle\Service\CrudService;

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

            return $resposta;
        }
    }
}