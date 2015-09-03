<?php
namespace Super\TransacaoBundle\Service;

use Base\BaseBundle\Entity\TbTransacao;
use Base\BaseBundle\Service\Data;
use Base\CrudBundle\Service\CrudService;

class TipoTransacao extends CrudService
{
    CONST CREDITO = 1;
    CONST DEBITO = 2;
    CONST BONUS = 3;

    protected $entityName = 'Base\BaseBundle\Entity\TbTipoTransacao';
}