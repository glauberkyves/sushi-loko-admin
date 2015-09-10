<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 10/09/2015
 * Time: 14:29
 */

namespace Super\FeedbackBundle\Service;

use Base\CrudBundle\Service\CrudService;

class FeedbackQuestao extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFeedbackQuestao';
}