<?php

namespace Super\BaseBundle\Controller;

use Base\BaseBundle\Service\Pesquisa;
use Base\CrudBundle\Controller\CrudController;
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
        $this->vars['cmbSexo']     = Pesquisa::getComboSexo();
        $this->vars['cmbPeriodo']  = Pesquisa::getComboPeriodo();
        $this->vars['cmbOperador'] = Pesquisa::getComboOperador();
        $this->vars['cmbFranquia'] = $this->getService('service.franquia')->getComboDefault(array(
            'stAtivo' => true,
            'idFranqueador' => 56
        ));
        $this->vars['arrFranquia'] = array();

        reset($this->vars['cmbFranquia']);
        unset($this->vars['cmbFranquia'][key($this->vars['cmbFranquia'])]);

        return $this->render($this->resolveRouteName(), $this->vars);
    }
}
