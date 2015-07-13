<?php

namespace Super\FranqueadorBundle\Controller;

use Base\BaseBundle\Service\Dominio;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.franqueador';

    public function indexAction(Request $request)
    {
        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        return parent::indexAction($request);
    }

    public function createAction(Request $request)
    {
        $this->getCombos();

        return parent::createAction($request);
    }

    public function editAction(Request $request)
    {
        $this->getCombos();

        return parent::editAction($request);
    }

    public function getCombos()
    {
        $this->vars['cmbEstado']    = $this->getService('service.estado')->getComboDefault(
            array(),
            array('noEstado' => 'asc')
        );
        $this->vars['cmbMunicipio'] = array('' => 'Selecione');
        $this->vars['cmbBairro']    = array('' => 'Selecione');
    }

    public function mapaAction()
    {
        return $this->render('SuperFranqueadorBundle:Default:mapa.html.twig');
    }

    public function resolveRouteIndex()
    {
        return $this->generateUrl('super_franqueador_index');
    }
}
