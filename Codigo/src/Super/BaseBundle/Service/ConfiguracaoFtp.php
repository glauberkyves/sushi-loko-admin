<?php

namespace Super\BaseBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;

class ConfiguracaoFtp extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbConfiguracaoFtp';

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
    }

    public function preSave(AbstractEntity $entity = null)
    {
        $idFranqueador     = $this->getRequest()->request->get('idFranqueador');
        $entityFranqueador = $this->getService('service.franqueador')->find($idFranqueador);

        if($entityOld = $this->findOneByIdFranqueador($entityFranqueador)){
            $entityOld->populate($this->getRequest()->request->all());
            $this->entity = $entityOld;
        }

        $this->entity->setIdFranqueador($entityFranqueador);

        $this->entity->setNoUsuario(trim($this->entity->getNoUsuario()));
        $this->entity->setNoSenha(trim($this->entity->getNoSenha()));
        $this->entity->setNoPasta(trim($this->entity->getNoPasta()));
    }
}