<?php

namespace Super\CardapioBundle\Service;

use Base\CrudBundle\Service\CrudService;

class Produto extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbProduto';
}