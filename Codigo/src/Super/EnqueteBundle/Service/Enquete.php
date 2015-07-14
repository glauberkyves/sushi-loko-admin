<?php

namespace Super\EnqueteBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class Enquete extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbEnquete';

 

    public function preSave(AbstractEntity $entity = null)
    {

        $this->entity->setDtCadastro(new \DateTime());

        if ($this->getRequest()->request->get('dtInicio')) {
            $this->entity->setDtInicio(Data::dateBr($this->getRequest()->request->get('dtInicio')));
        }

        $this->entity->setDtFim(Data::dateBr($this->getRequest()->request->get('dtFim')));

    }

    public function postSave(AbstractEntity $entity = null)
    {
        $ActionUpdate = $this->getRequest()->request->get("updateEnquete");
        if ($ActionUpdate) {
            $total = $this->getRequest()->request->get("total");
            for ($i = 1; $i <= $total; $i++) {
                $id       = $this->getRequest()->request->get("idResposta" . $i);
                $resposta = $this->getRequest()->request->get("resposta" . $i);
                $entidade = $this->getService('service.enquete_resposta')->find($id);

                if ($entidade) {
                    $entidade->setNoResposta($resposta);
                    $this->persist($entidade);
                }
            }
        } else {
            for ($i = 1; $i <= 3; $i++) {
                $entidade = $this->getService('service.enquete_resposta')->newEntity();
                $entidade->setIdEnquete($this->entity);

                $resposta = $this->getRequest()->request->get("resposta" . $i);
                if ($resposta) {
                    $entidade->setNoResposta($resposta);
                    $this->persist($entidade);
                }
            }
        }
    }

    public function postRemove(AbstractEntity $entity = null)
    {
        $this->addMessage($this->container->get('translator')->trans('base_bundle.messages.success'));
    }


}