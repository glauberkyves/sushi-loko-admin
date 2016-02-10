<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 15/07/2015
 * Time: 11:14
 */
namespace Super\MobileBundle\Controller;

use Base\BaseBundle\Service\Data;

class UsuarioController extends AbstractMobile
{
    /**
     * Cadastrar usuário
     * @param nuCpf , dtNascimento, noSenha, noPessoa, noEmail, sgSexo, nuTelefone
     * @return Response
     */
    public function cadastrarAction()
    {
        $request = $this->getRequest();

//        $request->nuCpf = '76820441878';
//        $request->idFranqueador = '56';
//        $request->dtNascimento = '10101991';
//        $request->nuCep = '73801450';
//        $request->noSenha = '123456';
//        $request->noPessoa = 'Teste User';
//        $request->noEmail = 'teste-user@gmail.com';
//        $request->sgSexo = 'M';
//        $request->nuTelefone = '6182828282';

        $idFranqueadorUsuario = $this->getService('service.franqueador_usuario')->findUsuarioPorFranqueador(
            $request->nuCpf,
            $request->idFranqueador
        );

        if (!$idFranqueadorUsuario) {
            if ($request->dtNascimento) {
                $request->dtNascimento = substr_replace($request->dtNascimento, '-', 2, 0);
                $request->dtNascimento = substr_replace($request->dtNascimento, '-', 5, 0);
                $request->dtNascimento = Data::dateBr($request->dtNascimento);
            }

            if ($request->nuCep) {
                $request->nuCep = preg_replace('/\D/', '', $request->nuCep);
            }

            $this->getParentRequest()->request->set('nuCpf', $request->nuCpf);
            $this->getParentRequest()->request->set('noSenha', $request->noSenha);
            $this->getParentRequest()->request->set('noPessoa', $request->noPessoa);
            $this->getParentRequest()->request->set('noEmail', $request->noEmail);
            $this->getParentRequest()->request->set('sgSexo', $request->sgSexo);
            $this->getParentRequest()->request->set('nuTelefone', $request->nuTelefone);
            $this->getParentRequest()->request->set('dtNascimento', $request->dtNascimento ?: null);
            $this->getParentRequest()->request->set('nuCep', $request->nuCep);

            $idUsuario     = $this->getService('service.usuario')->save();
            $idFranqueador = $this->getService('service.franqueador')->find($request->idFranqueador);

            if ($idUsuario) {
                $this->getService('service.franqueador_usuario')->saveFranqueadorUsuario($idFranqueador, $idUsuario);

                $this->add('valido', true);
                $this->add('mensagem', 'mobile_bundle.usuario.cadastrar.success');
                $this->add('idUsuario', $idUsuario->getIdUsuario());
            } else {
                $this->add('mensagem', 'mobile_bundle.usuario.cadastrar.exception');
            }
        } else {
            $this->add('mensagem', 'mobile_bundle.usuario.cadastrar.error');
        }

        return $this->response();
    }

    /**
     * Editar usuário
     * @param idUsuario , noSenha, noSenhaNova, noPessoa, noEmail, sgSexo, nuTelefone, dtNascimento
     * @return Response
     */
    public function editarAction()
    {
        $request = $this->getRequest();

        $idUsuario = $this->getService('service.usuario')->find($request->idUsuario);

        if ($idUsuario) {
            if ($idUsuario->getNoSenha() == md5($request->noSenha)) {
                $this->getService()->updateUser($request, $idUsuario);

                $pessoaFisica = $idUsuario->getIdPessoa()->getIdPessoaFisica();
                $dtNascimento = $pessoaFisica->getDtNascimento() ? $pessoaFisica->getDtNascimento()->format('d/m/Y') : '';

                $result = current($this->getService('service.logradouro')->getDadosCep($pessoaFisica->getNuCep()));

                if(!$result){
                    $result = array();
                }

                $data = array(
                    'idUsuario'    => $idUsuario->getIdUsuario(),
                    'noPessoa'     => $idUsuario->getIdPessoa()->getNoPessoa(),
                    'nuCpf'        => $pessoaFisica->getNuCpf(),
                    'noEmail'      => $pessoaFisica->getNoEmail(),
                    'dtNascimento' => $dtNascimento,
                    'nuTelefone'   => $pessoaFisica->getNuTelefone(),
                    'sgSexo'       => $pessoaFisica->getSgSexo(),
                    'nuCep'        => $pessoaFisica->getNuCep(),
                    'arrEndereco'  => $result
                );

                $this->add('dados', $data);
                $this->add('valido', true);
                $this->add('mensagem', 'mobile_bundle.usuario.editar.success');

            } else {
                $this->add('mensagem', 'mobile_bundle.usuario.editar.error_senha');
            }
        } else {
            $this->add('mensagem', 'mobile_bundle.usuario.editar.error');
        }

        return $this->response();
    }

    /**
     * Login
     * @param idFranqueador , nuCpf , noSenha
     * @return Response
     */
    public function autenticarAction()
    {
        $request = $this->getRequest();

        $user = $this->getService('service.usuario')->getByCpfEmailSenha(
            $request->nuCpf, md5($request->noSenha), $request->idFranqueador
        );

        if ($user) {
            if ($user = $this->getService()->login($user)) {

                $pessoaFisica = $user->getIdPessoa()->getIdPessoaFisica();
                $dtNascimento = $pessoaFisica->getDtNascimento() ? $pessoaFisica->getDtNascimento()->format('d/m/Y') : '';

                $result = current($this->getService('service.logradouro')->getDadosCep($pessoaFisica->getNuCep()));

                if(!$result){
                    $result = array();
                }

                $data = array(
                    'idUsuario'    => $user->getIdUsuario(),
                    'noPessoa'     => $user->getIdPessoa()->getNoPessoa(),
                    'nuCpf'        => $pessoaFisica->getNuCpf(),
                    'noEmail'      => $pessoaFisica->getNoEmail(),
                    'dtNascimento' => $dtNascimento,
                    'nuTelefone'   => $pessoaFisica->getNuTelefone(),
                    'sgSexo'       => $pessoaFisica->getSgSexo(),
                    'nuCep'        => $pessoaFisica->getNuCep(),
                    'arrEndereco'  => $result
                );

                $this->add('valido', true);
                $this->add('dados', $data);

            } else {
                $this->add('mensagem', 'mobile_bundle.usuario.autenticar.exception');
            }
        } else {
            $this->add('mensagem', 'mobile_bundle.usuario.autenticar.error');
        }

        return $this->response();
    }

    /**
     * Recuperar senha
     * @param noEmail
     * @return Response
     */
    public function recuperarSenhaAction()
    {
        $request    = $this->getRequest();
        $srvUsuario = $this->getService('service.site.usuario');

        $user = $this->getService('service.pessoa_fisica')->findOneByNoEmail(
            $request->noEmail
        );

        if ($user) {
            if ($srvUsuario->recuperarSenha($user->getIdPessoa()->getIdUsuario())) {

                $this->add('valido', true);
                $this->add('mensagem', 'mobile_bundle.usuario.recuperar_senha.success');

            } else {
                $this->add('mensagem', 'mobile_bundle.usuario.recuperar_senha.exception');
            }
        } else {
            $this->add('mensagem', 'mobile_bundle.usuario.recuperar_senha.error');
        }

        return $this->response();
    }

    /**
     * Atualizar posicao do usuario
     * @param idUsuario , noLatitude, noLongitude
     * @return Response
     */
    public function atualizarPosicaoAction()
    {
        $request = $this->getRequest();

        $stAtualizacao = $this->getService()->atualizarPosicao(
            $request->idUsuario,
            $request->noLatitude,
            $request->noLongitude
        );

        $this->add('valido', $stAtualizacao);

        return $this->response();
    }

    /**
     * Extrato do usuário
     * @param idUsuario
     * @return mixed
     */
    public function extratoAction()
    {
        $request = $this->getRequest();

        $arrExtrato   = array();
        $queryExtrato = $this->getService('service.transacao')->getExtratoPorUsuario($request->idUsuario);

        foreach ($queryExtrato as $key => $extrato) {
            $extrato['dtDia']   = $extrato['dtCadastro']->format('d/m/Y');
            $extrato['dtHora']  = $extrato['dtCadastro']->format('H:i');
            $extrato['nuValor'] = sprintf("%s", number_format($extrato['nuValor'], 2, ',', '.'));
            $arrExtrato[$key]   = $extrato;
        }

        $this->add('valido', true);
        $this->add('arrExtrato', $arrExtrato);

        return $this->response();
    }

    /**
     * Logout
     * @return Response
     */
    public function logoutAction()
    {
        $this->getService()->logout();
        $this->add('valido', true);

        return $this->response();
    }
}