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
     * Busca inteligente
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

        $result = $request->getSession()->get('arrUsuarios', array());

        //parametros grid
        if ($request->query->has('sEcho') && $request->query->has('sEcho')) {
            $result     = $this->getService()->getRepository()->getResultGrid($request);
            $resultGrid = $this->getResultGrid($request, $result);
            $request->getSession()->set('arrUsuarios', $result);
            return $this->renderJson($resultGrid);
        }

        //parametros exportacao
        if ($request->query->has('exportar')) {
            $response = $this->render('SuperBaseBundle:Default:usuariosCSV.html.twig', array(
                'arrUsuarios' => $result
            ));
            return $this->getService()->exportar($response);
        }

        // parametros filtro acrescentar pontos e bonus
        if ($request->query->has('addPontos') && $request->query->has('addBonus')) {
            return $this->renderJson($this->getService()->addPontosBonus($result));
        }

        return $this->render($this->resolveRouteName(), $this->vars);
    }

    /**
     * Alterar comportamento do getResultGrid()
     * @param Request $request
     * @param $result
     * @return array
     */
    public function getResultGrid(Request $request, array $result = array())
    {
        $sEcho = $request->query->get('sEcho', 1);
        $page  = $request->query->get('iDisplayStart', 0);
        $rows  = $request->query->get('iDisplayLength', 5);
        $page  = ceil($page/$rows);

        $paginator  = new \Knp\Component\Pager\Paginator();
        $pagination = $paginator->paginate($result, $page, $rows);

        $data                       = new \StdClass();
        $data->sEcho                = $sEcho;
        $data->iTotalRecords        = $pagination->getTotalItemCount();
        $data->iTotalDisplayRecords = $pagination->getTotalItemCount();
        $data->records              = $pagination->getTotalItemCount();
        $data->aaData               = $this->getService()->parserItens($pagination->getItems());

        return (array)$data;
    }
}
