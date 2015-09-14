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

    public function adicionar($args = array())
    {
        if ($args) {
            $entity = new TbFeedbackQuestaoResposta();

            $entity->setIdFeedbackQuestao($args['idQuestao']);
            $entity->setNuResposta($args['nuResposta']);
            $entity->setIdUsuario($args['idUsuario']);
            $entity->setIdFranquia($args['idFranquia']);
            $entity->setIdTipoFeedback($args['idTipoFeedback']);
            $entity->setDsResposta($args['dsResposta']);
            $entity->setDtCadastro(new \DateTime());

            $this->persist($entity);

            $idRequisicao = $this->getService('service.requisicao_transacao')->find($args['idRequisicao']);
            $idRequisicao->setIdFeedbackQuestaoResposta($entity);

            $this->persist($idRequisicao);

            return $entity;
        }
    }
}