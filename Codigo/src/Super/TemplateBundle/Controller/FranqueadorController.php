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

    public function viewAction(Request $request, $id)
    {
        if(!$id){
            return $this->redirect($this->generateUrl('super_franqueador_template_index'));
        }

        $this->vars['entity'] = $this->getService()->find($request->get('id'));

        if(!$this->vars['entity']){
            return $this->redirect($this->generateUrl('super_franqueador_template_index'));
        }

        if ($request->isMethod('post') && $this->vars['entity']) {
            $this->vars['entity'] = $this->vars['entity']->populate($request->request->all());
        }

        $this->vars['dados'] = false;

        return $this->render($this->resolveRouteName(), $this->vars);
    }

    public function getCombo()
    {
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $this->getRequest()->request->set('idFranqueador', $idFranqueador);
        $this->vars['cmb'] = $this->getService()->combo($idFranqueador);
    }
}
