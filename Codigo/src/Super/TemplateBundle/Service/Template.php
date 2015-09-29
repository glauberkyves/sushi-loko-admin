<?php
namespace Super\TemplateBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Symfony\Component\Validator\Validator;

class Template extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbTemplateEmail';

}