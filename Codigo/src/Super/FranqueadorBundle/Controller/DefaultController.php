<?php

namespace Super\FranqueadorBundle\Controller;

use Base\BaseBundle\Service\Data;
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

    public function localidadeAction()
    {
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $arrUsuario    = $this->getService('service.usuario')->getLocalidades($idFranqueador);

        return $this->renderJson($arrUsuario);
    }

    public function dashboardAction(Request $request)
    {
        $srvUsuario   = $this->getService("service.usuario");
        $srvTransacao = $this->getService("service.transacao");
        $nuMes        = $request->query->get('mes', date('m'));

        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();

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