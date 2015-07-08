<?php

namespace Super\FranquiaBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Base\BaseBundle\Service\Dominio;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.franquia';

    public function indexAction(Request $request, $idFranqueador = null)
    {
        $this->vars['idFranqueador'] = $idFranqueador;
        $this->vars['cmbStatus']     = Dominio::getStAtivo();

        return parent::indexAction($request);
    }

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

    public function localidadeAction()
    {
        $franquia = $this->getService('service.franquia')->jsonLocalidade();
        return $this->renderJson($franquia);
    }

    public function resolveRouteIndex()
    {
        return $this->generateUrl('super_franquia_index', array(
            'idFranqueador' => $this->getRequest()->get('idFranqueador')
        ));
    }
<<<<<<< HEAD

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

=======
>>>>>>> 130b6795521f3b88d3afa1277cfd6e4c9c272f13
}
