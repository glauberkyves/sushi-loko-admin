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
        $this->entity->setDtCadastro(new \DateTime());
        $dtInicio = $this->getRequest()->request->get('dtInicio');
        $this->entity->setDtInicio(Data::dateBr($dtInicio));
        $idFranqueador = $this->getService('service.franqueador')->findOneByIdUsuario($this->getUser()->getIdUsuario());
        $this->entity->setIdFranqueador($idFranqueador);
    }
}