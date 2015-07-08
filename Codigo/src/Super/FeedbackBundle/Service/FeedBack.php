<?php

namespace Super\FeedbackBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class FeedBack extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFeedback';

}