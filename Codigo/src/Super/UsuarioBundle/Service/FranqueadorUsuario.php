<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 17/07/2015
 * Time: 18:06
 */

namespace Super\UsuarioBundle\Service;

use Base\BaseBundle\Entity\TbFranqueador;
use Base\BaseBundle\Entity\TbUsuario;
use Base\CrudBundle\Service\CrudService;
use Doctrine\ORM\Query\Expr;

class FranqueadorUsuario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranqueadorUsuario';

    public function saveFranqueadorUsuario(TbFranqueador $idFranqueador = null, TbUsuario $idUsuario = null)
    {
        $idFranqueadorUsuario = $this->newEntity();
        $idFranqueadorUsuario->setIdFranqueador($idFranqueador);
        $idFranqueadorUsuario->setIdUsuario($idUsuario);
        $idFranqueadorUsuario->setDtCadastro(new \DateTime());

        return $this->persist($idFranqueadorUsuario);
    }

    public function findUsuarioPorFranquia($nuCpf, $nuCodigoLoja)
    {
        return $this->getRepository()->findUsuarioPorFranquia($nuCpf, $nuCodigoLoja);
    }
}