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
        $lista = array();

        foreach($usuariosCadastrados as $value)
        {
            $dia = new \DateTime($value["dtCadastro"]);

            array_push($lista, array(
                "device" => $dia->format('d/m'),
                "geekbench" => $value["total"]
            ));
        }

        $this->vars['jsonUser'] = json_encode($lista);

        return parent::indexAction($request);
    }

    public function pesquisaAction(Request $request)
    {
        $this->serviceName = 'service.pesquisa';
        $arrUsuarios       = array();

        if ($request->query->has('sgSexo')) {
            $arrUsuarios = $this->getService()->getRepository()->getResultGrid($request);
            print_r($arrUsuarios);die;
        }

        $this->vars['entity']      = $this->getService()->newEntity()->populate($request->query->all());
        $this->vars['arrUsuarios'] = $arrUsuarios;

        return $this->render($this->resolveRouteName(), $this->vars);
    }
}
