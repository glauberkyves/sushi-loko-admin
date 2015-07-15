<?php

namespace Super\SecurityBundle\Security;

use Symfony\Component\DependencyInjection\Container;

class Token
{
    private $key, $iv;
    private $en = 'AES-256-CBC';

    public function __construct(Container $container)
    {
        $this->key = $container->getParameter('token_key');
        $this->iv  = $container->getParameter('token_iv');
    }

    public function token($token)
    {
        return (object)json_decode($this->decrypt($token));
    }

    public function sendToken(array $params = array())
    {
        return $this->encrypt(json_encode($params));
    }

    public function encrypt($string = '')
    {
        return openssl_encrypt($string, $this->en, $this->key, false, $this->iv);
    }

    public function decrypt($string = '')
    {
        return openssl_decrypt($string, $this->en, $this->key, false, $this->iv);
    }
}