<?php

namespace Super\SecurityBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Super\UsuarioBundle\Service\Usuario;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends CrudController
{
    /**
     * @var Usuario
     */
    protected $serviceName = 'service.usuario';
    protected $provider, $authenticator;

    public function loginAction(Request $request)
    {
        return $this->render($this->resolveRouteName(), array(
            'error' => $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR)
        ));
    }

    public function logarAction(Request $request)
    {
        return $this->render($this->resolveRouteName(), array(
            'error' => $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR)
        ));
    }
}
