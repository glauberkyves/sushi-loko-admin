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
     * @param idUsuario, idFranqueador
     * @return Response
     */
    public function creditoAction()
    {
        $request = $this->getRequest();

        $credito = $this->getService('service.transacao')->getCreditosUsuario(
            $request->idUsuario, $request->idFranqueador
        );

        $this->add('valido', true);
        $this->add('credito', $credito);

        return $this->response();
    }

    /**
     * Gerar senha para o usuário (utilizar bônus)
     * @param idUsuario, idFranqueador, nuValor
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

            $totalCredito = $this->getService('service.transacao')->getCreditosUsuario(
                $request->idUsuario,
                $request->idFranqueador
            );

            if ($request->nuValor > 0) {
                if ($request->nuValor <= $totalCredito) {
                    try {
                        $noSenha = $this->getService('service.transacao')->requisicaoTransacaoUsuario(
                            $franqueadorUsuario->getIdUsuario(),
                            $franqueadorUsuario->getIdFranqueador(),
                            $request->nuValor
                        );

                        $this->add('valido', true);
                        $this->add('senha', $noSenha);
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
            $this->add('mensagem', 'mobile_bundle.transacao.obter_senha.error_usuario');
        }

        return $this->response();
    }
}