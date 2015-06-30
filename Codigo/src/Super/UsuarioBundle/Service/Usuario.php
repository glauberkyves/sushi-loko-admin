<?php

namespace Super\UsuarioBundle\Service;

use Base\CrudBundle\Service\CrudService;

class Usuario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbUsuario';
}