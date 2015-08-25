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

        $nuCpf         = $request->request->getDigits('nuCpf');
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

    public function requisicaoTransacaoUsuarioAction(Request $request)
    {
        $response = array();

        $criteria  = array(
            'idUsuario'     => $request->request->getInt('idUsuario'),
            'idFranqueador' => $request->request->getInt('idFranqueador')
        );
        $franqueadorUsuario = $this->getService('service.franqueador_usuario')->findOneBy($criteria);
        $nuValor   = substr_replace($request->request->get('nuValor'), '.', strlen($request->request->get('nuValor')) - 3, 1);

        if (!$franqueadorUsuario) {
            $response['status']  = false;
            $response['message'] = utf8_encode('Usuário não encontrado.');

            return new JsonResponse($response);
        }

        $totalCredito = $this->getService()->getCreditosUsuario(
            $franqueadorUsuario->getIdUsuario()->getIdPessoa()->getIdPessoaFisica()->getNuCpf(),
            $franqueadorUsuario->getIdFranqueador()->getIdFranqueador()
        );

        if (!$nuValor || $nuValor <= 0) {
            $response['status']  = false;
            $response['message'] = 'Valor de utilização deve ser maior que zero.';
        } elseif ($nuValor > $totalCredito) {
            $response['status']  = false;
            $response['message'] = 'Valor deve ser menor que o total de créditos';
        } else {
            try {
                $noSenha = $this->getService()->requisicaoTransacaoUsuario(
                    $franqueadorUsuario->getIdUsuario(),
                    $franqueadorUsuario->getIdFranqueador(),
                    $nuValor
                );

                $response['status']  = true;
                $response['message'] = "Operação realizada com sucesso. Informe essa senha no caixa: {$noSenha}";

            } catch (\Exception $exp) {
                $response['status']  = false;
                $response['message'] = $exp->getMessage();
            }
        }

        $response['message'] = utf8_encode($response['message']);

        return new JsonResponse($response);
    }
}
