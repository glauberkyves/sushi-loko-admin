<?php

namespace Super\FranquiaBundle\Controller;

use Base\BaseBundle\Service\Data;
use Base\BaseBundle\Service\Mask;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Base\BaseBundle\Service\Dominio;
use Knp\Component\Pager\Paginator;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.franquia';

    /**
     * Página inicial do franqueado (FRANQUEADOR)
     * @param Request $request
     * @param null $idFranqueador
     * @return Response
     */
    public function indexAction(Request $request, $idFranqueador = 0)
    {
        $security = $this->get('security.authorization_checker');

        switch (true) {
            case $security->isGranted('ROLE_SUPER'):
                $this->vars['idFranqueador'] = $idFranqueador;
                break;
            case $security->isGranted('ROLE_FRANQUEADOR'):
                $idFranqueador               = $this->getUser()->getIdFranqueador()->getIdFranqueador();
                $this->vars['idFranqueador'] = $idFranqueador;
                break;
            case $security->isGranted('ROLE_FRANQUIA'):
                return $this->render('SuperFranquiaBundle:Default:dashboard.html.twig', $this->getDashboardData($request));
                break;
        }

        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        return parent::indexAction($request);
    }

    /**
     * Página inicial do franqueado (SUPER)
     * @param Request $request
     * @return Response
     */
    public function superIndexAction(Request $request)
    {
        $this->serviceName       = 'service.franqueador_franquia';
        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        return parent::indexAction($request);
    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    public function superIndexFranquiaAction(Request $request)
    {
        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        return parent::indexAction($request);
    }

    /**
     * Cadastro do franqueado
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request, $idFranqueador = null)
    {
        $this->vars = $this->getService()->getCombos($idFranqueador);

        return parent::createAction($request);
    }

    /**
     * Edição do franqueado
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request)
    {
        $this->vars = $this->getService()->getCombos();

        return parent::editAction($request);
    }

    /**
     * Buscar usuário por nome ou email
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function buscarUsuarioAction()
    {
        $response = $this->getService()->buscarUsuario();

        return $this->renderJson($response);
    }

    /**
     * Busca localidade dos usuários
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function localidadeAction()
    {
        $franquia = $this->getService('service.franqueador')->selectLocalidade();

        return $this->renderJson($franquia);
    }

    /**
     * Configura nova index após uma operação
     * @return string
     */
    public function resolveRouteIndex()
    {
        return $this->generateUrl('super_franquia_index');
    }

    public function transacaoAction(Request $request)
    {
        if ($request->isMethod('post')) {
            $idTransacao     = $request->request->get('idTransacao');
            $stAtivo         = $request->request->get('stAtivo');
            $dsJustificativa = $request->request->get('dsJustificativa');

            try {
                $this->getService('service.transacao')->saveTransacaoJustificativa($idTransacao, $stAtivo, $dsJustificativa);

                $this->addMessage('Operação realizada com sucesso.');
            } catch (\Exception $exp) {
                $this->addMessage($exp->getMessage(), 'error');
            }
        } else {

            $idFranquia = $this->getUser()->getIdFranquia()->getIdFranquia();
            $request->query->set('idFranquia', $idFranquia);

            $arrTransacao = $this->getService('service.transacao')->getTransacaoFranquia($request);

            if ($request->query->has('sEcho')) {
                $sEcho = $request->query->get('sEcho');
                $page  = $request->query->get('iDisplayStart', 1);
                $rows  = $request->query->get('iDisplayLength', 10);

                $paginator  = new Paginator();
                $pagination = $paginator->paginate($arrTransacao, $page, $rows);

                $data                       = new \StdClass();
                $data->sEcho                = $sEcho;
                $data->iTotalRecords        = $page;
                $data->iTotalDisplayRecords = ceil($pagination->getTotalItemCount() / $rows);
                $data->records              = $pagination->getTotalItemCount();
                $data->aaData               = $pagination->getItems();
                $arrStatus                  = array('Cancelado', 'Ativo');

                foreach ($data->aaData as $key => $value) {
                    foreach ($value as $keyIten => $iten) {
                        $data->aaData[$key]['nuCpf']      = Mask::mask($value['nuCpf'], '###.###.###-##');
                        $data->aaData[$key]['dtCadastro'] = $value['dtCadastro']->format('d/m/Y H:i:s');
                        $data->aaData[$key]['nuValor']    = 'R$ ' . number_format($value['nuValor'], 2, ',', '.');
                        $data->aaData[$key]['stAtivo']    = isset($arrStatus[$value['stAtivo']]) ? $arrStatus[$value['stAtivo']] : '';

                        $data->aaData[$key]['opcoes'] = $this->container->get('templating')->render(
                            'SuperFranquiaBundle:Default:gridOptionsTransacao.html.twig',
                            array(
                                'data' => (object)$value,
                                'cpf'  => $data->aaData[$key]['nuCpf'],
                            )
                        );
                    }
                }

                if ($request->query->has('export')) {
                    return $this->getService('service.transacao')->excelTransacao($data->aaData, false);
                }

                return new JsonResponse((array)$data);
            }
        }

        return $this->render($this->resolveRouteName());
    }

    private function getDashboardData(Request $request)
    {
        $srvTransacao  = $this->getService("service.transacao");
        $idFranqueador = $this->getUser()->getIdFranquia()->getIdFranqueador()->getIdFranqueador();
        $nuMes         = $request->query->get('mes', date('m'));

        $countTransCredito = $srvTransacao->getTransacoesCredito($nuMes, $idFranqueador);
        $countTransDebito  = $srvTransacao->getTransacoesDebito($nuMes, $idFranqueador);
        $countTransacao    = $srvTransacao->getTransacoes($nuMes, $idFranqueador);
        $cmbMes            = Data::getComboMes();

        $arrTransacao = array();

        foreach ($countTransCredito as $key => $t) {
            $arrTransacao[] = array(
                'credito' => $t['transacaoCredito'],
                'debito'  => 0,
                'data'    => $t['dtCadastro']
            );
        }

        foreach($countTransDebito as $k => $c) {
            $arrTransacao[] = array(
                'credito' => 0,
                'debito'  => $c['transacaoDebito'],
                'data'    => $c['dtCadastro']
            );
        }

        $this->vars['jsonTransacao']  = json_encode($arrTransacao);
        $this->vars['countTransacao'] = $countTransacao;
        $this->vars['cmbMes']         = $cmbMes;
        $this->vars['nuMes']          = $nuMes;

        return $this->vars;
    }
}