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
     */
    public function listarAction()
    {
        $request       = $this->getRequest();

        $srvTransacao  = $this->getService('service.transacao');
        $srvUsuario    = $this->getService('service.usuario');
        $srvEnquete    = $this->getService('service.enquete');
        $srvFeedback   = $this->getService('service.feedback');
        $srvRequisicao = $this->getService('service.requisicao_transacao');

        $arrSend       = $srvTransacao->getSendTagsByIdUsuario($request->idUsuario);
        $arrRemove     = $srvTransacao->getRemoveTagsByIdUsuario($request->idUsuario);

        $idUsuario     = $srvUsuario->find($request->idUsuario);
        $idFeedback    = $srvFeedback->findOneByStAtivo(true);
        $idEnquete     = $srvEnquete->listarEnqueteByIdUsuario($request->idFranqueador, $request->idUsuario);
        $idEnquete     = $srvEnquete->find($idEnquete);
        $idRequisicao  = $srvRequisicao->getUltimaTransacao($request->idUsuario);


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

        //caso não tenha respondido a ultima requisicao
        $this->add('responderFeedback', false);

        if($idRequisicao) {
            if (!$idRequisicao->getIdFeedbackQuestaoResposta()->getIdFeedbackQuestaoResposta()) {
                if($idRequisicao->getIdTransacao()->getIdFranquia()) {
                    $arrResposta = array();
                    foreach ($idFeedback->getIdFeedbackQuestao() as $idQuestao) {
                        $arrResposta[] = array(
                            'idResposta' => $idQuestao->getIdFeedbackQuestao(),
                            'noResposta' => $idQuestao->getNoQuestao()
                        );
                    }
                    $this->add('responderFeedback', true);
                    $this->add('feedback', array(
                        'idFranquia' => $idRequisicao->getIdTransacao()->getIdFranquia()->getIdFranquia(),
                        'idRequisicao' => $idRequisicao->getIdRequisacaoTransacao(),
                        'noPergunta' => $idFeedback->getNoFeedback(),
                        'arrResposta' => $arrResposta
                    ));
                }
            }
        }

        //caso exista um feedback ativo
        $this->add('opiniaoAtiva', false);

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
                'noPergunta'  => $idFeedback->getNoFeedback(),
                'arrResposta' => $arrResposta
            ));
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