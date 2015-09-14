<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 14/09/2015
 * Time: 13:30
 */

namespace Super\FeedbackBundle\Service;

use Base\CrudBundle\Service\CrudService;

class TipoFeedback extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbTipoFeedback';
}