<?php
namespace Super\TransacaoBundle\Service;

use Base\CrudBundle\Service\CrudService;

class RequisicaoTransacao extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbRequisacaoTransacao';
}