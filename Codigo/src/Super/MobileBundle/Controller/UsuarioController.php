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
     * @param nuCpf, dtNascimento, noSenha, noPessoa, noEmail, sgSexo
     * @return Response
     */
    public function cadastrarAction()
    {
        $request = $this->getRequest();

        $idFranqueador = $this->getService('service.franqueador')->find($request->idFranqueador);
        $idUsuario     = $this->getService('service.usuario')->findOneBy(array(
            'nuCpf' => $request->nuCpf
        ));

        if (!$idUsuario) {

            $request->dtNascimento = substr_replace($request->dtNascimento, '/', 2, 0);
            $request->dtNascimento = substr_replace($request->dtNascimento, '/', 5, 0);

            $this->getRequest()->request->set('nuCpf',    $request->nuCpf);
            $this->getRequest()->request->set('noSenha',  $request->noSenha);
            $this->getRequest()->request->set('noPessoa', $request->noPessoa);
            $this->getRequest()->request->set('noEmail',  $request->noEmail);
            $this->getRequest()->request->set('sgSexo',   $request->sgSexo);
            $this->getRequest()->request->set('dtNascimento', Data::dateBr($request->dtNascimento));

            $idUsuario = $this->getService('service.usuario')->save();

            if ($idUsuario) {
                $this->getService('service.franqueador_usuario')->saveFranqueadorUsuario($idFranqueador, $idUsuario);

                $this->add('valido' ,   true);
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
     * Login
     * @param nuCpf, noSenha
     * @return Response
     */
    public function autenticarAction()
    {
        $request = $this->getRequest();

        $user = $this->getService('service.usuario')->getByCpfSenha(
            $request->nuCpf, md5($request->noSenha)
        );

        if($user) {
            if($user = $this->getService()->login($user)) {

                $pessoaFisica = $user->getIdPessoa()->getIdPessoaFisica();

                $data = array(
                    'idUsuario'      => $user->getIdUsuario(),
                    'noPessoa'       => $user->getIdPessoa()->getNoPessoa(),
                    'nuCpf'          => $pessoaFisica->getNuCpf(),
                    'noEmail'        => $pessoaFisica->getNoEmail(),
                    'dtNascimento'   => $pessoaFisica->getDtNascimento()->format('d/m/Y'),
                    'sgSexo'         => $pessoaFisica->getSgSexo()
                );

                $this->add('valido', true);
                $this->add('dados',  $data);

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
            if($srvUsuario->recuperarSenha($user->getIdPessoa()->getIdUsuario())) {

                $this->add('valido',   true);
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