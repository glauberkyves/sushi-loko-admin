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
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $arrTransacao  = $this->getService('service.transacao')->getTransacaoFranqueador($idFranqueador);

        if ($request->query->has('sEcho') && $request->query->has('sEcho')) {
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
            $data->aaData               = $this->getService()->parserItens($pagination->getItems(), false);

            foreach ($data->aaData as $key => $value) {
                foreach ($value as $keyIten => $iten) {
                    $data->aaData[$key]['nuCpf'] = Mask::mask($value['nuCpf'], '###.###.###-##');

                    $data->aaData[$key]['opcoes'] = $this->container->get('templating')->render(
                        'SuperFranqueadorBundle:Transacao:gridOptionsTransacao.html.twig',
                        array(
                            'data' => (object)$value,
                            'cpf'  => $data->aaData[$key]['nuCpf'],
                        )
                    );
                }
            }

            return new JsonResponse((array)$data);
        }

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
        }

        return $this->render($this->resolveRouteName(), $arrTransacao);
    }
}