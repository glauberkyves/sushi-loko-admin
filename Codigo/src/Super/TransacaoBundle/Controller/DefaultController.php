<?php

namespace Super\TransacaoBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.transacao';

    public function processarArquivoRetornoAction()
    {
        return new JsonResponse($this->getService('service.arquivo')->processarArquivoRetorno());
    }

    public function saqueAction(Request $request)
    {
        $response = array();

        $nuCpf         = $request->request->get('nuCpf');
        $idFranqueador = $this->getUser()->getIdFranquiaOperador()->getIdFranquia()->getIdFranqueador()->getIdFranqueador();
        $nuCodigoLoja  = $this->getUser()->getIdFranquiaOperador()->getIdFranquia()->getNuCodigoLoja();
        $nuValor       = $request->request->get('nuValor');
        $noSenha       = $request->request->get('noSenha');

        if (!$nuCpf || !$nuCodigoLoja || (!$nuValor || $nuValor <= 0) || !$noSenha) {
            $response['status']  = false;
            $response['message'] = 'Preenchimento obrigatório de todos os campos.';
        } elseif ($nuValor <= 0) {
            $response['status']  = false;
            $response['message'] = 'Valor de utilização deve ser maior que zero.';
        } elseif (!$this->getService()->verificarSenhaApp($nuCpf, $nuCodigoLoja, $noSenha)) {
            $response['status']  = false;
            $response['message'] = 'Senha cliente inválida.';
        } else {
            try {
                $this->getService()->saque($nuCpf, $nuCodigoLoja, $nuValor);
                $response['status']       = true;
                $response['message']      = 'Operação realizada com sucesso.';
                $response['totalCredito'] = number_format($this->getService()->getCreditosUsuario($nuCpf, $idFranqueador), 2, ',', '.');

            } catch (\Exception $exp) {
                $response['status']  = false;
                $response['message'] = $exp->getMessage();
            }
        }

        $response['message'] = utf8_encode($response['message']);

        return new JsonResponse($response);
    }
}
