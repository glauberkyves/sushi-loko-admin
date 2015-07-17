<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 22/01/15
 * Time: 18:14
 */

namespace Super\UsuarioBundle\Service;

use Base\BaseBundle\Entity\RlUsuarioPerfil;
use Base\BaseBundle\Entity\TbUsuario;
use Base\CrudBundle\Service\CrudService;

class Perfil extends CrudService
{
    CONST SG_SUPER       = 'ROLE_SUPER';
    CONST SG_FRANQUEADOR = 'ROLE_FRANQUEADOR';
    CONST SG_FRANQUIA    = 'ROLE_FRANQUIA';
    CONST SG_OPERADOR    = 'ROLE_OPERADOR';
    CONST SG_USER        = 'ROLE_USER';

    protected $entityName = 'Base\BaseBundle\Entity\TbPerfil';

    public function savePerfil(TbUsuario $entity = null, $sgPerfil)
    {
        $entityUsuarioPerfil = new RlUsuarioPerfil();
        $entityUsuarioPerfil->setIdUsuario($entity);
        $entityUsuarioPerfil->setDtCadastro(new \DateTime());

        $entityPerfil = $this->findOneBySgPerfil($sgPerfil);
        $entityUsuarioPerfil->setIdPerfil($entityPerfil);

        return $this->persist($entityUsuarioPerfil);
    }
}