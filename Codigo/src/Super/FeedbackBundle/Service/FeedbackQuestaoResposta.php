<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 10/09/2015
 * Time: 17:52
 */

namespace Super\FeedbackBundle\Service;

use Base\BaseBundle\Entity\TbFeedbackQuestaoResposta;
use Base\CrudBundle\Service\CrudService;

class FeedbackQuestaoResposta extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFeedbackQuestaoResposta';

    public function adicionar(
        $idUsuario   = null,
        $idFranquia  = null,
        $idFeedback  = null,
        $resposta = array(),
        $dsResposta  = null)
    {
        $idQuestao = $this->getService('service.feedback_questao')->find($resposta->idResposta);

        $entity = new TbFeedbackQuestaoResposta();

        $entity->setIdFeedbackQuestao($idQuestao);
        $entity->setNuResposta($resposta->nuResposta);
        $entity->setIdUsuario($idUsuario);
        $entity->setIdFranquia($idFranquia);
        $entity->setDsResposta($dsResposta);
        $entity->setDtCadastro(new \DateTime());

        $this->persist($entity);
    }
}