<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 22/01/15
 * Time: 18:14
 */

namespace SiteBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;

class Imovel extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbImovel';

    public function preSave(AbstractEntity $entity = null)
    {
        $entityEndereco = $this->getService('service.endereco')->save();
        $idTipoImovel   = $this->getRequest()->request->getInt('idTipoImovel');

        $entityTipoImovel = $this
            ->getService('service.tipo_imovel')
            ->find($idTipoImovel);

        $entityEndereco = $this
            ->getService('service.endereco')
            ->find($entityEndereco->getIdEndereco());

        $this->entity->setIdTipoImovel($entityTipoImovel);
        $this->entity->setIdEndereco($entityEndereco);

        $this->entity->setNuCodigo($this->generateCodigoImovel());
        $this->entity->setNuValor($this->getRequest()->request->getDigits('nuValor'));
        $this->entity->setQtQuartos($this->getRequest()->request->getDigits('qtQuartos'));
        $this->entity->setQtSuites($this->getRequest()->request->getDigits('qtSuites'));
        $this->entity->setQtBanheiros($this->getRequest()->request->getDigits('qtBanheiros'));
        $this->entity->setQtLavabos($this->getRequest()->request->getDigits('qtLavabos'));
        $this->entity->setQtGaragem($this->getRequest()->request->getDigits('qtGaragem'));
        $this->entity->setNuAndar($this->getRequest()->request->getDigits('nuAndar'));
        $this->entity->setQtAndares($this->getRequest()->request->getDigits('qtAndares'));
        $this->entity->setNuValorMetro($this->getRequest()->request->getDigits('nuValorMetro'));
        $this->entity->setNuAreaUtil($this->getRequest()->request->getDigits('nuAreaUtil'));
        $this->entity->setNuValorCondominio($this->getRequest()->request->getDigits('nuValorCondominio'));
    }

    public function generateCodigoImovel()
    {
        $ano    = date('y');
        $result = $this->getRepository()->findAll(array(), array('idImovel' => 'DESC'));
        $lastId = 300;

        if ($result) {
            $lastId += $result[0]->getIdImovel();
        }

        $codigo = $ano . $lastId;

        return str_pad($codigo, 6, "0", STR_PAD_LEFT);
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $this->saveCaracteristica();

        $this->getRequest()->request->set('idImovel', $this->entity->getIdImovel());
        $this->getService('service.galeria')->save();
    }

    public function saveCaracteristica()
    {
        if ($this->getRequest()->request->has('caracteristica')) {
            $idImovel          = $this->entity->getIdImovel();
            $arrCaracteristica = $this->getService('service.rl_imovel_caracteristica')->findByIdImovel($idImovel);

            foreach ($arrCaracteristica as $entityOld) {
                $this->remove($entityOld);
            }

            foreach ($this->getRequest()->get('caracteristica') as $caracteristica) {
                $idCacteristica = $this->getService('service.imovel_caracteristica')->find($caracteristica);

                $entity = $this->getService('service.rl_imovel_caracteristica')->newEntity();
                $entity->setIdImovelCarateristica($idCacteristica);
                $entity->setIdImovel($this->entity);

                $this->persist($entity);
            }
        }
    }
}