<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 14/07/2015
 * Time: 18:43
 */
namespace Super\MobileBundle\Service;

use Base\BaseBundle\Service\Data;
use Base\CrudBundle\Service\CrudService;

class Mobile extends CrudService
{
    protected $entityName = '';

    /**
     * Realiza o login do usuário manualmente
     * @param null $user
     * @return mixed
     */
    public function login($user = null)
    {
        return $user;
        /**
         * TODO
         * Verificar erro ao fazer login manual
         */
        /*
        if($user && $this->getRequest()) {
            $token = new UsernamePasswordToken($user, null, "login_firewall", $user->getRoles());
            $this->getService("security.context")->setToken($token);

            $event = new InteractiveLoginEvent($this->getRequest(), $token);
            $this->getService("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $this->getUser();
        }
        */
    }

    /**
     * Atualizar posicao do usuario
     * @param int $idUsuario
     * @param int $noLatitude
     * @param int $noLongitude
     * @return bool
     */
    public function atualizarPosicao($idUsuario = 0, $noLatitude = 0, $noLongitude = 0)
    {
        $idUsuario = $this->getService('service.usuario')->find($idUsuario);

        if ($idUsuario) {
            $idUsuario->setNoLatitude($noLatitude);
            $idUsuario->setNoLongitude($noLongitude);

            $this->persist($idUsuario);

            return true;
        }

        return false;
    }

    /**
     * Realiza o logout do usuário manualmente
     */
    public function logout()
    {
        $this->getService('security.context')->setToken(null);
        $this->getService('request')->getSession()->invalidate();
    }

    /**
     * Retorna imagem codificada em base64
     * @param $filename
     * @return array('extensao', 'imagem')
     */
    public function getInfoFile($filename = null)
    {
        $file             = array();
        $file["extensao"] = '';
        $file["imagem"]   = '';

        if($filename) {
            $path = $this->getRequest()->server->get('DOCUMENT_ROOT') . DIRECTORY_SEPARATOR;

            if(file_exists($path . $filename)) {
                $file["extensao"] = current(array_reverse(explode('.', $filename)));
                $file["imagem"] = base64_encode(file_get_contents($path . $filename));
            }
        }

        return $file;
    }

    /**
     * Retorna o host
     * @return string
     */
    public function siteURL() {
        $protocol = "http://";
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
            $protocol = "https://";
        }
        return $protocol.$_SERVER['HTTP_HOST'];
    }

    /**
     * @param Object $request
     * @param null $idUsuario
     * @return dtNascimento, noSenhaNova, noPessoa, noEmail, sgSexo, nuTelefone
     */
    public function updateUser($request, $idUsuario = null)
    {
        $idPessoa       = $idUsuario->getIdPessoa();
        $idPessoaFisica = $idPessoa->getIdPessoaFisica();

        if (isset($request->dtNascimento) && $request->dtNascimento) {
            $request->dtNascimento = substr_replace($request->dtNascimento, '-', 2, 0);
            $request->dtNascimento = substr_replace($request->dtNascimento, '-', 5, 0);
            $request->dtNascimento = Data::dateBr($request->dtNascimento);

            $idPessoaFisica->setDtNascimento($request->dtNascimento);
        }
        if (isset($request->sgSexo) && $request->sgSexo) {
            $idPessoaFisica->setSgSexo($request->sgSexo);
        }
        if (isset($request->nuTelefone) && $request->nuTelefone) {
            $idPessoaFisica->setNuTelefone($request->nuTelefone);
        }
        if (isset($request->noEmail) && $request->noEmail) {
            $idPessoaFisica->setNoEmail($request->noEmail);
        }
        if (isset($request->noPessoa) && $request->noPessoa) {
            $idPessoa->setNoPessoa($request->noPessoa);
        }
        if (isset($request->noSenhaNova) && $request->noSenhaNova) {
            $idUsuario->setNoSenha(md5($request->noSenhaNova));
        }

        $this->persist($idPessoaFisica);
        $this->persist($idPessoa);
        $this->persist($idUsuario);

        return $idUsuario;
    }
}