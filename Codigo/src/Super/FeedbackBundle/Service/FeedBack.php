<?php

namespace Super\FeedbackBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class FeedBack extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFeedback';

    public function preInsert(AbstractEntity $entity = null)
    {
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $idFranqueador = $this->getService('service.franqueador')->findOneByIdUsuario($idFranqueador);
        $dtInicio      = $this->getRequest()->request->get('dtInicio');

        $this->entity->setDtInicio(Data::dateBr($dtInicio));
        $this->entity->setIdFranqueador($idFranqueador);
        $this->entity->setDtCadastro(new \DateTime());
    }

    public function preUpdate(AbstractEntity $entity = null)
    {
        $dtInicio = $this->getRequest()->request->get('dtInicio');

        $this->entity->setDtInicio(Data::dateBr($dtInicio));
    }
}