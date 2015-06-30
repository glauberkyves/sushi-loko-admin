<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 23/01/15
 * Time: 13:51
 */

namespace Base\BaseBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;

class Endereco extends AbstractService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbEndereco';

    public function preSave(AbstractEntity $entity = null)
    {
        $idMunicipio = $this->getRequest()->request->getInt('idMunicipio');

        $entityMunicipio = $this
            ->getService('service.municipio')
            ->find($idMunicipio);

        if($this->getRequest()->request->getInt('idBairro')){
            $entityBairro = $this
                ->getService('service.bairro')
                ->find($this->getRequest()->request->getInt('idBairro'));

            $this->entity->setIdBairro($entityBairro);
        }

        $this->entity->setIdMunicipio($entityMunicipio);
    }
}