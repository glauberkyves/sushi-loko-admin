<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 27/08/2015
 * Time: 16:49
 */

namespace Super\MobileBundle\Controller;

class FeedbackController extends AbstractMobile
{
    /**
     * Responder feedback
     * @param idUsuario, idFranquia, dsResposta, tipo, idRequisicao, arrResposta[idResposta, nuResposta]
     * @return Response
     */
    public function responderAction()
    {
        $request = $this->getRequest();

        $idUsuario      = $this->getService('service.usuario')->find($request->idUsuario);
        $idFranquia     = $this->getService('service.franquia')->find($request->idFranquia);
        $idTipoFeedback = $this->getService('service.tipo_feedback')->find($request->tipo);

        if($idUsuario) {
            foreach ($request->arrResposta as $resposta) {
                $idQuestao = $this->getService('service.feedback_questao')->find($resposta->idResposta);

                $this->getService('service.feedback_questao_resposta')->adicionar(
                    array(
                        'idUsuario'      => $idUsuario,
                        'idFranquia'     => $idFranquia,
                        'idTipoFeedback' => $idTipoFeedback,
                        'idQuestao'      => $idQuestao,
                        'nuResposta'     => $resposta->nuResposta,
                        'dsResposta'     => $request->dsResposta,
                        'idRequisicao'   => $request->idRequisicao
                    )
                );

                //caso seja um feedback e não uma opinião
                try {
                    if ($idTipoFeedback->getIdTipoFeedback() == 1) {
                        $nuPontos   = $idQuestao->getIdFeedbackQuestao()->getIdFeedback()->getNuPontos();
                        $nuCreditos = $idQuestao->getIdFeedbackQuestao()->getIdFeedback()->getNuCreditos();
                        if ($nuPontos > 0) {
                            $this->getService('service.bonus')->setBonus(
                                $idUsuario->getIdFranqueadorUsuario(),
                                $idQuestao->getIdFeedbackQuestao()->getIdFeedback()->getNuPontos()
                            );
                        }
                        if ($nuCreditos > 0) {
                            $this->getService('service.enquete')->creditar(TipoTransacao::CREDITO, $nuCreditos, $idUsuario);
                        }
                    }
                } catch (\Exception $e) {

                }
            }

            $this->add('valido',   true);
            $this->add('mensagem', 'mobile_bundle.feedback.responder.success');

        } else {
            $this->add('mensagem', 'mobile_bundle.feedback.responder.error');
        }

        return $this->response();
    }
}