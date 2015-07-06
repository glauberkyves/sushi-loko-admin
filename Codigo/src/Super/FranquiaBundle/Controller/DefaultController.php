<?php

namespace Super\FranquiaBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.franquia';

    public function createAction(Request $request)
    {
        $this->getComboDefault();

        return parent::createAction($request);
    }

    public function editAction(Request $request)
    {
        $this->getComboDefault();

        return parent::editAction($request);
    }

    public function buscarUsuarioAction()
    {
        $response = $this->getService()->buscarUsuario();

        return $this->renderJson($response);
    }

    private function getComboDefault()
    {
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

        $this->vars = array(
            'cmbCardapio' => $cmbCardapio,
            'cmbPromocao' => $cmbPromocao,
            'cmbEstado'   => $cmbEstado,
            'arrCardapio' => array(),
            'arrPromocao' => array()
        );

        return $this->vars;
    }
}
