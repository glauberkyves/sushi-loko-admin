<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 16/07/2015
 * Time: 17:40
 */

namespace Super\FranquiaBundle\Service;

use Base\CrudBundle\Service\CrudService;

class FranquiaOpiniao extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranquiaOpiniao';

    public function adicionar($idFranquia = null, $idUsuario = null, $dsMensagem = null)
    {
        $opiniao = $this->newEntity();
        
        $opiniao->setIdFranquia($idFranquia);
        $opiniao->setIdUsuario($idUsuario);
        $opiniao->setDsMensagem($dsMensagem);
        $opiniao->setDtCadastro(new \DateTime());

        $this->persist($opiniao);

        return $opiniao;
    }
}