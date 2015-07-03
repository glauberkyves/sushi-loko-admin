<?php

namespace Super\FranquiaBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.franquia';

    public function createAction(Request $request)
    {
        $this->vars = array(
            'cmbCardapio' => array('asdf'),
            'cmbPromocao' => array('asdf'),
            'arrCardapio' => array('asdf','asdf','asdf'),
            'arrPromocao' => array('asdf','asdf','asdf')
        );

        return parent::createAction($request);
    }
}
