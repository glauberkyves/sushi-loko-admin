<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 14/07/2015
 * Time: 16:47
 */

namespace Super\FranquiaBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;

class FranquiaOperador extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranquiaOperador';

    public function preSave(AbstractEntity $entity = null)
    {
        $request        = $this->getRequest()->request;
        $entityFranquia = $this->getService('service.franquia')->find($request->get('idFranquia'));
        $arrIdOperador  = $request->get('idOperador');

        foreach ($entityFranquia->getIdFranquiaOperador() as $idFranquiaOperador) {
            $this->remove($idFranquiaOperador);
        }

        foreach($arrIdOperador as $idOperador)
        {
            $entityOperador = $this->getService('service.usuario')->find($idOperador);

            $franquiaOperador = $this->newEntity();
            $franquiaOperador->setIdFranquia($entityFranquia);
            $franquiaOperador->setIdOperador($entityOperador);
            $franquiaOperador->setDtCadastro(new \DateTime());

            $this->persist($franquiaOperador);
        }
    }
}