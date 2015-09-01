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

    /**
     * @param Request $request
     * @return Response
     */
    public function pesquisaAction(Request $request)
    {
        $this->serviceName = 'service.pesquisa';

        $this->vars['entity']      = $this->getService()->newEntity()->populate($request->query->all());
        $this->vars['cmbSexo']     = Pesquisa::getComboSexo();
        $this->vars['cmbPeriodo']  = Pesquisa::getComboPeriodo();
        $this->vars['cmbOperador'] = Pesquisa::getComboOperador();
        $this->vars['cmbFranquia'] = $this->getService('service.franquia')->getComboDefault(array(
            'stAtivo' => true,
            'idFranqueador' => 56
        ));

        reset($this->vars['cmbFranquia']);
        unset($this->vars['cmbFranquia'][key($this->vars['cmbFranquia'])]);

        if ($request->query->has('exportar')) {
            $result   = $this->getService()->getRepository()->getResultGrid($request);
            $response = $this->render('SuperBaseBundle:Default:usuariosCSV.html.twig', array(
                'arrUsuarios' => $result
            ));
            return $this->getService()->exportar($response, $result);
        }

        if ($request->query->has('addPontos') && $request->query->has('addBonus')) {
            $result = $this->getService()->getRepository()->getResultGrid($request);
            return $this->renderJson($this->getService()->addPontosBonus($result));
        }

        return parent::indexAction($request);
    }
}
