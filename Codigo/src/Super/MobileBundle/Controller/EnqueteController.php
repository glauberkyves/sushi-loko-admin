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
        $request     = $this->getRequest();
        $arrResposta = array();

        $idEnquete = $this->getService('service.enquete')->listarEnqueteByIdUsuario(
            $request->idFranqueador,
            $request->idUsuario
        );
        $idEnquete = $this->getService('service.enquete')->find($idEnquete);
        $arrSend   = $this->getService('service.transacao')->getSendTagsByIdUsuario($request->idUsuario);
        $arrRemove = $this->getService('service.transacao')->getRemoveTagsByIdUsuario($request->idUsuario);

        if ($idEnquete) {
            foreach ($idEnquete->getIdResposta() as $idResposta) {
                $arrResposta[] = array(
                    'idResposta' => $idResposta->getIdResposta(),
                    'noResposta' => $idResposta->getNoResposta()
                );
            }
            $this->add('responderEnquete', true);
            $this->add('enquete', array(
                'idEnquete' => $idEnquete->getIdEnquete(),
                'noPergunta' => $idEnquete->getNoPergunta(),
                'arrResposta' => $arrResposta
            ));
        } else {
            $this->add('responderEnquete', false);
        }

        $arrTags = array(
            'send' => $arrSend ?: array(),
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