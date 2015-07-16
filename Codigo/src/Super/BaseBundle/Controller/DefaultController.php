<?php

namespace Super\BaseBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.usuario';

    public function indexAction(Request $request)
    {
        $usuariosCadastrados = $this->getService("service.usuario")->usuariosCadastradosSemana();
        $lista               = array();
        foreach ($usuariosCadastrados as $value) {
            $total = $value["total"];
            $dia   = $value["dtCadastro"];

            $data = array("device" => $dia, "geekbench" => $total);
            array_push($lista, $data);
        }

        $jsonUser = json_encode($lista);

        return $this->render('SuperBaseBundle:Default:index.html.twig', array("jsonUser" => $jsonUser));
    }

    public function pesquisaAction()
    {
        return $this->render('SuperBaseBundle:Default:pesquisa.html.twig');
    }
}
