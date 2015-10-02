<?php

namespace Super\TemplateBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class FranqueadorController extends CrudController
{
    protected $serviceName = 'service.template';

    public function indexAction(Request $request)
    {
        $this->getCombo();

        return parent::indexAction($request);
    }

    public function createAction(Request $request)
    {
        $this->getCombo();

        return parent::createAction($request);
    }

    public function editAction(Request $request)
    {
        $this->getCombo();

        return parent::editAction($request);
    }

    public function getCombo()
    {
        $this->getRequest()->request->set('idFranqueador', $this->getUser()->getIdFranqueador()->getIdFranqueador());
        $this->vars['cmb'] = $this->get('service.tipo_template')->getComboDefault();
    }
}
