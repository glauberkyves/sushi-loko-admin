<?php

namespace Super\UsuarioBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;

class Usuario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbUsuario';

    public function preInsert(AbstractEntity $entity = null)
    {
        $idPessoa = $this->getService('service.pessoa')->save();

        $this->entity->setIdPessoa($idPessoa);
        $this->entity->setNoSenha(md5($this->entity->getNoSenha()));
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setDtAtualizacao(new \DateTime());
        $this->entity->setStAtivo(true);

        /**
         * TODO
         * Verificar relacionamento pessoa -> pessoa_fisica
         */
    }
}