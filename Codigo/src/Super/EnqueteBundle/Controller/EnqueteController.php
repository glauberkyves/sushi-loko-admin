<?php

namespace Super\EnqueteBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EnqueteController extends CrudController
{
    protected $serviceName = 'service.enquete';

    public function relatorioAction(Request $request)
    {
        $this->serviceName = "service.relatorio_enquete";
        return parent::indexAction($request);
    }
}
