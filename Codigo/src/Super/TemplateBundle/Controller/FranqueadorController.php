<?php

namespace Super\TemplateBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class FranqueadorController extends CrudController
{
    protected $serviceName = 'service.template';

    public function indexAction(Request $request)
    {
        $this->vars['cmb'] = $this->get('service.tipo_template')->getComboDefault();

        return parent::indexAction($request);
    }
}
