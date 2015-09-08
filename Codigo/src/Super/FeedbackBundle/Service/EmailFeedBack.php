<?php

namespace Super\FeedbackBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class EmailFeedBack extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbEmailFeedback';


    public function registerEmailFaadBack($mensagem)
    {
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $idFranqueador = $this->getService('service.franqueador')->find($idFranqueador);
        $feedback      = $this->getService('service.feedback_email')->findOneByIdFranqueador(
            $idFranqueador->getIdFranqueador()
        );

        if(!$feedback) {
            $feedback = $this->getService('service.feedback_email')->newEntity();
            $feedback->setIdFranqueador($idFranqueador);
        }

        $feedback->setDsMensagem($mensagem);
        $this->persist($feedback);

    }

}