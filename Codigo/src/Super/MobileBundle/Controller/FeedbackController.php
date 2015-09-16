<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 27/08/2015
 * Time: 16:49
 */

namespace Super\MobileBundle\Controller;

use Super\TransacaoBundle\Service\TipoTransacao;

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

//        $request->idUsuario = 75;
//        $request->idFranquia = 5;
//        $request->dsResposta = 'mobile';
//        $request->tipo = 1;
//        $request->idRequisicao = 25;
//        $request->arrResposta = array(
//            (object)array('idResposta' => 7, 'nuResposta' => 5),
//            (object)array('idResposta' => 8, 'nuResposta' => 5),
//            (object)array('idResposta' => 9, 'nuResposta' => 5)
//        );

        $idUsuario      = $this->getService('service.usuario')->find($request->idUsuario);
        $idFranquia     = $this->getService('service.franquia')->find($request->idFranquia);
        $idTipoFeedback = $this->getService('service.tipo_feedback')->find($request->tipo);

        if($idUsuario) {
            $idQuestao = null;
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
            }

            if($idQuestao) {
                //caso seja um feedback e não uma opinião, add pontos ou creditos
                if ($idTipoFeedback->getIdTipoFeedback() == 1) {
                    $nuPontos = $idQuestao->getIdFeedback()->getNuPontos();
                    $nuCreditos = $idQuestao->getIdFeedback()->getNuCreditos();
                    if ($nuPontos > 0) {
                        $this->getService('service.bonus')->setBonus(
                            $idUsuario->getIdFranqueadorUsuario(),
                            $idQuestao->getIdFeedback()->getNuPontos()
                        );
                    }
                    if ($nuCreditos > 0) {
                        $this->getService('service.enquete_resposta_usuario')->creditar(
                            TipoTransacao::CREDITO,
                            $nuCreditos,
                            $idUsuario
                        );
                    }
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