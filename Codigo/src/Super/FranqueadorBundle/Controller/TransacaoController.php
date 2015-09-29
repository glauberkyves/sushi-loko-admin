<?php

namespace Super\FranqueadorBundle\Controller;

use Base\BaseBundle\Service\Mask;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\Paginator;

class TransacaoController extends CrudController
{
    protected $serviceName = 'service.franqueador';

    public function indexAction(Request $request)
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

            $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
            $request->query->set('idFranqueador', $idFranqueador);
            $params = $this->getService('service.transacao')->getTransacaoFranqueador($request);
            $cmb    = $this->getService('service.franquia')->getComboDefault(array('idFranqueador' => $idFranqueador));

            if ($request->query->has('sEcho') && $request->query->has('sEcho')) {
                $sEcho = $request->query->get('sEcho');
                $page  = $request->query->get('iDisplayStart', 1);
                $rows  = $request->query->get('iDisplayLength', 10);

                $paginator  = new Paginator();
                $pagination = $paginator->paginate($params, $page, $rows);

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
                            'SuperFranqueadorBundle:Transacao:gridOptionsTransacao.html.twig',
                            array(
                                'data' => (object)$value,
                                'cpf'  => $data->aaData[$key]['nuCpf'],
                            )
                        );
                    }
                }

                if ($request->query->has('export')) {
                    return $this->getService('service.transacao')->excelTransacao($data->aaData, true);
                }

                return new JsonResponse((array)$data);
            }
        }

        return $this->render($this->resolveRouteName(), array('cmb' => $cmb));
    }
}