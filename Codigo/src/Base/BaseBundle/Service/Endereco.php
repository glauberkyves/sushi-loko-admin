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
        $idMunicipio     = $this->getRequest()->request->getInt('idMunicipio');
        $idBairro        = $this->getRequest()->request->getInt('idBairro');
        $nuCep           = $this->getRequest()->request->getDigits('nuCep');

        $entityMunicipio = $this->getService('service.municipio')->find($idMunicipio);
        $entityBairro    = $this->getService('service.bairro')->find($idBairro);

        $this->entity->setNuCep($nuCep);
        $this->entity->setIdBairro($entityBairro ?: null);
        $this->entity->setIdMunicipio($entityMunicipio ?: null);
    }
}