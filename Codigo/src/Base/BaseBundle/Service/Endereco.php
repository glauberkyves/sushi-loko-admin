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

        $entityMunicipio = $this->getService('service.municipio')->find($idMunicipio);
        $entityBairro    = $this->getService('service.bairro')->find($idBairro);

        $this->entity->setIdBairro($entityBairro ?: null);
        $this->entity->setIdMunicipio($entityMunicipio ?: null);
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $this->entity->setNuCep($this->getRequest()->request->getDigits('nuCep'));

        $this->persist($this->entity);
    }
}