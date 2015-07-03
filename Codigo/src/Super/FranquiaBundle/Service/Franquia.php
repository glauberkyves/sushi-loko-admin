<?php

namespace Super\FranquiaBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;

class Franquia extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranquia';

    public function preSave(AbstractEntity $entity = null)
    {
        $idEndereco    = $this->getService('service.endereco')->save();
        $idFranqueador = $this->getService('service.franqueador')->find(
            $this->getRequest()->request->getInt('idFranqueador')
        );

        $this->entity->setIdEndereco($idEndereco);
        $this->entity->setIdFranqueador($idFranqueador);
    }

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setStAtivo(true);
    }
}