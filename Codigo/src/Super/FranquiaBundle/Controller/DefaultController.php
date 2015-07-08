<?php

namespace Super\FranquiaBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    public function localidadeAction()
    {
        $franquia = $this->getService('service.franquia')->jsonLocalidade();
        return $this->renderJson($franquia);
    }

    private function getComboDefault($idFranquia = null)
    {
        $arrCardapio = $arrPromocao = array();

        $cmbCardapio = $this->getService('service.cardapio')->getComboDefault(
            array('stAtivo' => 1),
            array('noCardapio' => 'ASC')
        );
        $cmbPromocao = $this->getService('service.promocao')->getComboDefault(
            array('stAtivo' => 1),
            array('noPromocao' => 'ASC')
        );
        array_shift($cmbPromocao);

        $cmbEstado = $this->getService('service.estado')->getComboDefault(
            array(),
            array('noEstado' => 'asc')
        );

//        $idFranquia = $this->getService()->find(
//            $this->getRequest()->get('id')
//        );

        $this->vars = array(
            'cmbCardapio' => $cmbCardapio,
            'cmbPromocao' => $cmbPromocao,
            'cmbEstado'   => $cmbEstado,
            'arrCardapio' => array(),
            'arrPromocao' => array()
        );

        return $this->vars;
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
