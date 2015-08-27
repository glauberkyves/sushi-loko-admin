<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 15/07/2015
 * Time: 11:14
 */
namespace Super\MobileBundle\Controller;

class CreditoController extends AbstractMobile
{
    /**
     * Total de créditos do usuário
     * @param idUsuario, idFranqueador
     * @return Response
     */
    public function creditoAction()
    {
        $request = $this->getRequest();

        $credito = $this->getService('service.transacao')->getCreditosUsuario(
            $request->idUsuario, $request->idFranqueador
        );

        $this->add('valido', true);
        $this->add('credito', $credito);

        return $this->response();
    }
}