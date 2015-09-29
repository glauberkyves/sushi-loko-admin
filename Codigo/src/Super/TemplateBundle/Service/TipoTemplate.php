<?php
namespace Super\TemplateBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Symfony\Component\Validator\Validator;

class TipoTemplate extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbTipoTemplate';

}