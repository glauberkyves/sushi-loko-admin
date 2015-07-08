<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 22/01/15
 * Time: 18:14
 */

namespace Super\UsuarioBundle\Service;

use Base\CrudBundle\Service\CrudService;

class Perfil extends CrudService
{
    CONST SG_SUPER = 'ROLE_SUPER';
    CONST SG_FRANQUEADOR = 'ROLE_FRANQUEADOR';
    CONST SG_FRANQUIA = 'ROLE_FRANQUIA';
    CONST SG_OPERADOR = 'ROLE_OPERADOR';
    CONST SG_USER = 'ROLE_USER';

    protected $entityName = 'Base\BaseBundle\Entity\TbPerfil';
}