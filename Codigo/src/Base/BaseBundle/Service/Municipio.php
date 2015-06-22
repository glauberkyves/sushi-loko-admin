<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 23/01/15
 * Time: 13:51
 */

namespace Base\BaseBundle\Service;

use Base\CrudBundle\Service\CrudService;

class Municipio extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbMunicipio';
}