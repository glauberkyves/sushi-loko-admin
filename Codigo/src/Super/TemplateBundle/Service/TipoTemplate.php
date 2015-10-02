<?php
namespace Super\TemplateBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Symfony\Component\Validator\Validator;

class TipoTemplate extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbTipoTemplate';

//    public function getComboDefault(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null)
//    {
//        return array('' => 'Selecione') + $this->getRepository()->getComboDefault($criteria, $orderBy, $limit, $offset);
//    }
}