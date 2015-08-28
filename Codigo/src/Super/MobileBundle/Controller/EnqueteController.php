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
     * @return Response
     */
    public function listarAction()
    {
        $request = $this->getRequest();

        return $this->response();
    }

    /**
     * Responder enquete
     * @param idEnqueteResposta, idUsuario
     * @return Response
     */
    public function responderAction()
    {
        $request = $this->getRequest();

        $idUsuario  = $this->getService('service.usuario')->find($request->idUsuario);
        $idResposta = $this->getService('service.enquete_resposta')->find($request->idEnqueteResposta);

        if($idUsuario && $idResposta) {

            $this->getService('service.enquete_resposta_usuario')->adicionar(
                $idUsuario, $idResposta
            );

            $this->add('valido',   true);
            $this->add('mensagem', 'mobile_bundle.enquete.responder.success');

        } else {
            $this->add('mensagem', 'mobile_bundle.enquete.responder.error');
        }

        return $this->response();
    }
}