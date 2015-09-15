<?php

namespace Super\FeedbackBundle\Service;

use Base\BaseBundle\Entity\TbFeedbackQuestao;
use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class FeedBack extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFeedback';

    public function preSave(AbstractEntity $entity = null)
    {
        $request  = $this->getRequest()->request;
        $dtInicio = $request->get('dtInicio');

        $this->entity->setDtInicio(Data::dateBr($dtInicio));
        $this->entity->setIdFranqueador($this->getUser()->getIdFranqueador());
        $this->entity->setNuCreditos($this->converteValor($request->get('nuCreditos')));
    }

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $arrQuestao = $this->getRequest()->request->get('arrQuestao', array());

        foreach ($arrQuestao as $key => $questao) {
            $entity = new TbFeedbackQuestao();

            $entity->setIdFeedback($this->entity);
            $entity->setNoQuestao($questao);
            $entity->setNuPosicao($key);

            $this->persist($entity);
        }
    }

    public function postUpdate(AbstractEntity $entity = null)
    {
        $arrQuestao = $this->getRequest()->request->get('arrQuestao', array());

        foreach ($arrQuestao as $key => $questao) {
            $entity = $this->getService('service.feedback_questao')->findOneBy(
                array(
                    'idFeedback' => $this->entity->getIdFeedback(),
                    'nuPosicao'  => $key
                )
            );
            if ($entity) {
                $entity->setNoQuestao($questao);
                $this->persist($entity);
            }
        }
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $arrFeedback   = $this->getService('service.feedback')->findByIdFranqueador($idFranqueador);

        if($this->entity->getStAtivo()) {
            foreach ($arrFeedback as $feedback) {
                $feedback->setStAtivo(false);
                $this->persist($feedback);
            }
            $this->entity->setStAtivo(true);
            $this->persist($this->entity);
        }
    }

    public function converteValor($nuValor)
    {
        return str_replace(",", ".", str_replace(".", "", $nuValor));
    }
}