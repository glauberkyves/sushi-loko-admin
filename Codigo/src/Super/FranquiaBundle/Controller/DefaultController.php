<?php

namespace Super\FranquiaBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.franquia';

    public function createAction(Request $request)
    {
        $this->vars = $this->getService()->getCombos();

        return parent::createAction($request);
    }

    public function editAction(Request $request)
    {
        $this->vars = $this->getService()->getCombos();

        return parent::editAction($request);
    }

    public function buscarUsuarioAction()
    {
        $response = $this->getService()->buscarUsuario();

        return $this->renderJson($response);
    }

//    /**
//     * ALTERAR A ROTA PARA A PÁGINA INICIAL DO FRANQUEADOR
//     */
//    public function resolveRouteIndex()
//    {
//        $request = $this->getRequest();
//        $idFranqueador = $request->request->get('idFranqueador') ?: $request->query->get('idFranqueador');
//
//        return $this->generateUrl('super_franquia_create', array(
//            'idFranqueador' => $idFranqueador
//        ));
//    }
}
