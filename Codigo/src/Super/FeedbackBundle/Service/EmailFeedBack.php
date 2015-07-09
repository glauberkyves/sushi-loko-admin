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
        $entidade = $this->getService('service.feedback_email')->findOneByIdFranqueador($this->getUser());
        $entidade->setDsMensagem($mensagem);
        $this->persist($entidade);
    }

}