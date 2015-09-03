<?php

namespace Super\FranqueadorBundle\Controller;

use Base\BaseBundle\Service\Dominio;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.franqueador';

    public function indexAction(Request $request)
    {
        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        return parent::indexAction($request);
    }

    public function createAction(Request $request)
    {
        $this->getCombos();

        return parent::createAction($request);
    }

    public function dashboardAction(Request $request)
    {
        $srvUsuario   = $this->getService("service.usuario");
        $srvTransacao = $this->getService("service.transacao");
        $dataSemana   = new \DateTime();

        $arrCountCadastro  = $srvUsuario->getUsuariosCadastradosSemana(56);
        $countTransCredito = $srvTransacao->getTransacoesCreditoPeriodo(56, $dataSemana->modify('-9 days'));
        $countTransDebito  = $srvTransacao->getTransacoesDebitoPeriodo(56, $dataSemana->modify('-9 days'));
        $countCadastro     = $srvUsuario->getUsuariosCadastradosOntem(56);
        $countTransacao    = $srvTransacao->getTransacoesOntem(56);

        $arrUsuario = $arrTransacao = array();

        foreach ($arrCountCadastro as $value) {
            $dia = new \DateTime($value["dtCadastro"]);
            array_push($arrUsuario, array(
                "data"     => $dia->format('d/m'),
                "usuarios" => $value["total"]
            ));
        }

        foreach ($countTransCredito as $key => $t) {
            $debito = 0;
            $c = $countTransDebito;
            if (isset($c[$key]['dtCadastro'])) {
                $debito = ($c[$key]['dtCadastro'] == $t['dtCadastro']) ? $c[$key]['transacaoDebito'] : 0;
            }
            $arrTransacao[] = array(
                'credito' => $t['transacaoCredito'],
                'debito' => $debito,
                'data'  => $t['dtCadastro']
            );
        }

        $this->vars['jsonUsuario']    = json_encode($arrUsuario);
        $this->vars['jsonTransacao']  = json_encode($arrTransacao);
        $this->vars['countCadastro']  = $countCadastro;
        $this->vars['countTransacao'] = $countTransacao;

        return parent::indexAction($request);
    }

    public function editAction(Request $request)
    {
        $this->getCombos();

        return parent::editAction($request);
    }

    public function getCombos()
    {
        $this->vars['cmbEstado']    = $this->getService('service.estado')->getComboDefault(
            array(),
            array('noEstado' => 'asc')
        );
        $this->vars['cmbMunicipio'] = array('' => 'Selecione');
        $this->vars['cmbBairro']    = array('' => 'Selecione');
    }

    public function mapaAction()
    {
        return $this->render('SuperFranqueadorBundle:Default:mapa.html.twig');
    }

    public function resolveRouteIndex()
    {
        return $this->generateUrl('super_franqueador_index');
    }
}