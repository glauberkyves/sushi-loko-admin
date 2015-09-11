<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 15/07/2015
 * Time: 11:14
 */
namespace Super\MobileBundle\Controller;

class EnqueteController extends AbstractMobile
{
    /**
     * Listar enquetes de um franqueador
     * @param idFranqueador, idUsuario
     * @return Response
     * @todo ID_FRANQUIA e ID_FEEDBACK está fixo!
     */
    public function listarAction()
    {
        $request       = $this->getRequest();

        $arrSend       = $this->getService('service.transacao')->getSendTagsByIdUsuario($request->idUsuario);
        $arrRemove     = $this->getService('service.transacao')->getRemoveTagsByIdUsuario($request->idUsuario);

        $idUsuario     = $this->getService('service.usuario')->find($request->idUsuario);
        $idFeedback    = $this->getService('service.feedback')->find(5);
        $idEnquete     = $this->getService('service.enquete')->listarEnqueteByIdUsuario(
            $request->idFranqueador,
            $request->idUsuario
        );
        $idEnquete  = $this->getService('service.enquete')->find($idEnquete);

        if ($idEnquete) {
            $arrResposta = array();
            foreach ($idEnquete->getIdResposta() as $idResposta) {
                $arrResposta[] = array(
                    'idResposta' => $idResposta->getIdResposta(),
                    'noResposta' => $idResposta->getNoResposta()
                );
            }
            $this->add('responderEnquete', true);
            $this->add('enquete', array(
                'idEnquete'   => $idEnquete->getIdEnquete(),
                'noPergunta'  => $idEnquete->getNoPergunta(),
                'arrResposta' => $arrResposta
            ));
        } else {
            $this->add('responderEnquete', false);
        }

        if($idFeedback) {
            $arrResposta = array();
            foreach ($idFeedback->getIdFeedbackQuestao() as $idQuestao) {
                $arrResposta[] = array(
                    'idResposta' => $idQuestao->getIdFeedbackQuestao(),
                    'noResposta' => $idQuestao->getNoQuestao()
                );
            }
            $this->add('responderFeedback', true);
            $this->add('feedback', array(
                'idFeedback'  => $idFeedback->getIdFeedback(),
                'idFranquia'  => 5,
                'noPergunta'  => $idFeedback->getNoFeedback(),
                'arrResposta' => $arrResposta
            ));
        } else {
            $this->add('responderFeedback', false);
        }

        if($idFeedback) {
            $arrResposta = array();
            foreach ($idFeedback->getIdFeedbackQuestao() as $idQuestao) {
                $arrResposta[] = array(
                    'idResposta' => $idQuestao->getIdFeedbackQuestao(),
                    'noResposta' => $idQuestao->getNoQuestao()
                );
            }
            $this->add('opiniaoAtiva', true);
            $this->add('opiniao', array(
                'idFeedback'  => $idFeedback->getIdFeedback(),
                'noPergunta'  => $idFeedback->getNoFeedback(),
                'arrResposta' => $arrResposta
            ));
        } else {
            $this->add('responderOpiniao', false);
        }

        $this->add('possuiBonus', false);
        if ($idBonus = $idUsuario->getIdFranqueadorUsuario()->getIdBonus()) {
            $nivel = $this->getService('service.franqueador')->getNivel(
                $request->idFranqueador,
                $idBonus->getNuBonus()
            );

            if($nivel) {
                $idConfig = (int)$nivel['idConfiguracaoFranquiaNivel']+1;
                $idConfig = $this->getService('service.configuracao_franquia_nivel')->find($idConfig);

                $arrBonus = array(
                    'noNivel' => $nivel['noNivel'],
                    'nuMin'   => $nivel['nuQuantidadePontosNecessaio'],
                    'nuMax'   => $idConfig ? $idConfig->getNuQuantidadePontosNecessaio() : null,
                    'nuBonus' => $idBonus->getNuBonus()
                );
                $this->add('possuiBonus', true);
                $this->add('bonus', $arrBonus);
            }
        }

        $arrTags = array(
            'send'   => $arrSend ?: array(),
            'remove' => $arrRemove ?: array()
        );

        $this->add('valido', true);
        $this->add('tags', $arrTags);

        return $this->response();
    }

    /**
     * Responder enquete
     * @param idEnquete, idResposta, idUsuario
     * @return Response
     */
    public function responderAction()
    {
        $request = $this->getRequest();

        $idUsuario  = $this->getService('service.usuario')->find($request->idUsuario);
        $idEnquete  = $this->getService('service.enquete')->find($request->idEnquete);
        $idResposta = $this->getService('service.enquete_resposta')->find($request->idResposta);

        if($idUsuario && $idEnquete) {

            $this->getService('service.enquete_resposta_usuario')->adicionar(
                $idUsuario, $idEnquete, $idResposta
            );

            $this->add('valido',   true);
            $this->add('mensagem', 'mobile_bundle.enquete.responder.success');

        } else {
            $this->add('mensagem', 'mobile_bundle.enquete.responder.error');
        }

        return $this->response();
    }
}