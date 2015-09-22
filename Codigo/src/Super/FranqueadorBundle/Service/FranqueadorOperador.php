<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 14/07/2015
 * Time: 16:47
 */

namespace Super\FranqueadorBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;

class FranqueadorOperador extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranqueadorOperador';

    public function saveFranquiaOperador(AbstractEntity $entity = null)
    {
        $entityFranquia = $this->getService('service.franquia')->findOneByIdUsuario($this->getUser());
        $entityOperador = $entity;

        $criteria = array(
            'idOperador' => $entity->getIdUsuario(),
            'idFranquia' => $entityFranquia->getIdFranquia(),
        );

        $franquiaOperador = $this->getService('service.franquia_operador')->findOneBy($criteria);

        if (null == $franquiaOperador) {
            $franquiaOperador = $this->newEntity();
            $franquiaOperador->setDtCadastro(new \DateTime());
        }

        $franquiaOperador->setIdFranquia($entityFranquia);
        $franquiaOperador->setIdOperador($entityOperador);

        $this->persist($franquiaOperador);
    }
}