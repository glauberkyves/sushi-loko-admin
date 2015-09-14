<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 15/07/2015
 * Time: 11:14
 */
namespace Super\MobileBundle\Controller;

class TransacaoController extends AbstractMobile
{
    /**
     * Total de créditos do usuário
     * @param idUsuario , idFranqueador
     * @return Response
     */
    public function creditoAction()
    {
        $request = $this->getRequest();

        $credito = $this->getService('service.transacao')->getCreditosUsuario(
            $request->idUsuario, $request->idFranqueador
        );

        $ultimoCodigo = $this->getService('service.requisicao_transacao')->findOneBy(
            array(
                'idUsuario'     => $request->idUsuario,
                'idFranqueador' => $request->idFranqueador,
                'stAtivo'       => true
            ),
            array('dtCadastro' => 'DESC'),
            1
        );

        $this->add('valido', true);
        $this->add('credito', number_format($credito, 2, ",", "."));
        $this->add('codigo', $ultimoCodigo ? $ultimoCodigo->getNoSenha() : '');

        return $this->response();
    }

    /**
     * Gerar senha para o usuário (utilizar crédito)
     * @param idUsuario , idFranqueador, nuValor
     * @return Response
     */
    public function obterSenhaAction()
    {
        $request = $this->getRequest();

        $franqueadorUsuario = $this->getService('service.franqueador_usuario')->findOneBy(array(
            'idUsuario'     => $request->idUsuario,
            'idFranqueador' => $request->idFranqueador
        ));

        if ($franqueadorUsuario) {

            if ($franqueadorUsuario->getIdUsuario()->getNoSenha() == md5($request->noSenha)) {

                if ($franqueadorUsuario->getIdFranqueador()->getNuValorMinimoResgate() <= $request->nuValor) {
                    $totalCredito = $this->getService('service.transacao')->getCreditosUsuario(
                        $request->idUsuario,
                        $request->idFranqueador
                    );

                    if ($request->nuValor > 0) {
                        if ($request->nuValor <= $totalCredito) {
                            try {
                                $noCodigo = $this->getService('service.transacao')->requisicaoTransacaoUsuario(
                                    $franqueadorUsuario->getIdUsuario(),
                                    $franqueadorUsuario->getIdFranqueador(),
                                    $request->nuValor
                                );

                                $this->add('valido', true);
                                $this->add('codigo', $noCodigo);
                                $this->add('mensagem', 'mobile_bundle.transacao.obter_senha.success');

                            } catch (\Exception $exp) {
                                $this->add('mensagem', 'mobile_bundle.transacao.obter_senha.exception');
                            }
                        } else {
                            $this->add('mensagem', 'mobile_bundle.transacao.obter_senha.error_valor');
                        }
                    } else {
                        $this->add('mensagem', 'mobile_bundle.transacao.obter_senha.error_valor_zero');
                    }
                } else {
                    $this->add('mensagem', 'mobile_bundle.transacao.obter_senha.error_valor_minimo');
                }
            } else {
                $this->add('mensagem', 'mobile_bundle.transacao.obter_senha.error_senha');
            }
        } else {
            $this->add('mensagem', 'mobile_bundle.transacao.obter_senha.error_usuario');
        }

        return $this->response();
    }
}