<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 14/07/2015
 * Time: 18:43
 */
namespace Super\MobileBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

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
}