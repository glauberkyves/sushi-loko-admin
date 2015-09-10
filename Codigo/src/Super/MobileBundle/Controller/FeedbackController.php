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
     * @param idFeedback, idUsuario, idFranquia, dsResposta, arrResposta[idResposta, nuResposta]
     * @return Response
     */
    public function responderAction()
    {
        $request = $this->getRequest();

        $idUsuario  = $this->getService('service.usuario')->find($request->idUsuario);
        $idFranquia = $this->getService('service.franquia')->find($request->idFranquia);
        $idFeedback = $this->getService('service.feedback')->find($request->idFeedback);

        if($idUsuario && $idFranquia) {
            foreach ($request->arrResposta as $resposta) {
                $this->getService('service.feedback_questao_resposta')->adicionar(
                    $idUsuario,
                    $idFranquia,
                    $idFeedback,
                    $resposta,
                    $request->dsResposta
                );
            }

            $this->add('valido',   true);
            $this->add('mensagem', 'mobile_bundle.feedback.responder.success');

        } else {
            $this->add('mensagem', 'mobile_bundle.feedback.responder.error');
        }

        return $this->response();
    }
}