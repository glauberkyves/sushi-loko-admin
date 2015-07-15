<?php

namespace Super\EnqueteBundle\Service;

use Base\CrudBundle\Service\CrudService;

class EnqueteRespostaUsuario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbEnqueteRespostaUsuario';

    public function adicionar($idUsuario = null, $idEnqueteResposta = null)
    {
        if($idUsuario && $idEnqueteResposta)
        {
            $resposta = $this->newEntity();
            $resposta->setIdUsuario($idUsuario);
            $resposta->setIdEnqueteResposta($idEnqueteResposta);
            $resposta->setDtCadastro(new \DateTime());

            $this->persist($resposta);

            return $resposta;
        }
    }
}