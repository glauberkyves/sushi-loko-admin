<?php

namespace Super\FranqueadorBundle\Service;

use Base\BaseBundle\Entity\TbFranqueador;
use Base\CrudBundle\Service\CrudService;

class ConfiguracaoFranquaiNivel extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbConfiguracaoFranquiaNivel';

    public function saveConfiguracaoNivel(TbFranqueador $franqueador)
    {
        $request = $this->getRequest()->request;

        foreach ($this->findByIdFranqueador($franqueador->getIdFranqueador()) as $entityOld) {
            $this->remove($entityOld);
        }

        $nives = $request->get('niveis');
        for ($i = 0; $i < count($nives['noNivel']); $i++) {
            $entity = $this->newEntity();

            $entity->setNoNivel($nives['noNivel'][$i]);
            $entity->setNuPorcentagemPontosExtra($nives['nuPorcentagemPontosExtra'][$i]);
            $entity->setNuQuantidadePontosNecessaio($nives['nuQuantidadePontosNecessaio'][$i]);
            $entity->setNuQuantidadePontosPorAtingir($nives['nuQuantidadePontosPorAtingir'][$i]);
            $entity->setDtCadastro(new \DateTime());
            $entity->setIdFranqueador($franqueador);

            $this->persist($entity);
        }
    }
}