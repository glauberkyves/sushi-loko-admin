<?php

namespace Super\BaseBundle\Controller;

use Base\BaseBundle\Service\Data;
use Base\BaseBundle\Service\Pesquisa;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.usuario';

    public function indexAction(Request $request)
    {
        $srvUsuario   = $this->getService("service.usuario");
        $srvTransacao = $this->getService("service.transacao");
        $nuMes        = $request->query->get('mes', date('m'));

        $idFranqueador = null;

        if ($this->getUser()->getIdFranqueador()) {
            $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        }

        $arrCountCadastro  = $srvUsuario->getUsuariosCadastrados($nuMes, $idFranqueador);
        $countTransCredito = $srvTransacao->getTransacoesCredito($nuMes, $idFranqueador);
        $countTransDebito  = $srvTransacao->getTransacoesDebito($nuMes, $idFranqueador);
        $countTransacao    = $srvTransacao->getTransacoes($nuMes, $idFranqueador);
        $cmbMes            = Data::getComboMes();

        $arrUsuario = $arrTransacao = array();

        foreach ((array) $arrCountCadastro as $value) {
            $dia = new \DateTime($value["dtCadastro"]);
            array_push($arrUsuario, array(
                "data"     => $dia->format('d/m'),
                "usuarios" => $value["total"]
            ));
        }

        foreach ($countTransCredito as $key => $t) {
            foreach($countTransDebito as $k => $c) {
                $debito = 0;
                if($c['dtCadastro'] == $t['dtCadastro']) {
                    $debito = ($c['dtCadastro'] == $t['dtCadastro']) ? $c['transacaoDebito'] : 0;
                    break;
                }
            }

            $arrTransacao[] = array(
                'credito' => $t['transacaoCredito'],
                'debito'  => $debito,
                'data'    => $t['dtCadastro']
            );
        }

        $this->vars['jsonUsuario']    = json_encode($arrUsuario);
        $this->vars['jsonTransacao']  = json_encode($arrTransacao);
        $this->vars['countCadastro']  = $arrCountCadastro ? $arrCountCadastro[0]['total'] : 0;
        $this->vars['countTransacao'] = $countTransacao;
        $this->vars['cmbMes']         = $cmbMes;
        $this->vars['nuMes']          = $nuMes;

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

        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $this->getRequest()->query->set('idFranqueador', $idFranqueador);

        $this->vars['entity']      = $this->getService()->newEntity()->populate($request->query->all());
        $this->vars['cmbSexo']     = Pesquisa::getComboSexo();
        $this->vars['cmbPeriodo']  = Pesquisa::getComboPeriodo();
        $this->vars['cmbOperador'] = Pesquisa::getComboOperador();
        $this->vars['cmbFranquia'] = $this->getService('service.franquia')->getComboDefault(array(
            'stAtivo'       => true,
            'idFranqueador' => $idFranqueador
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
            $template = 'SuperBaseBundle:Default:usuariosCSV.html.twig';

            if($request->query->get('exportar') == 'excel'){
                return $this->getService()->exportarExcel($result);
            }

            $response = $this->render($template, array(
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
        $page  = ceil($page / $rows);

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
