<?php

namespace Super\SecurityBundle\Security;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;
    protected $container;

    public function __construct(Router $router, SecurityContext $security, Container $container)
    {
        $this->router    = $router;
        $this->security  = $security;
        $this->container = $container;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $redirect = $this->container->get('session')->get('redirect');
        $this->container->get('session')->remove('redirect');

        switch (true) {
            case $this->security->isGranted('ROLE_SUPER'):
                $response = new RedirectResponse($this->router->generate('super_home'));
                break;

            case $this->security->isGranted('ROLE_USER'):
                if ($redirect) {
                    $response = new RedirectResponse($redirect);
                } else {
                    $response = new RedirectResponse($this->router->generate('site_homepage'));
                }
                break;
        }

        return $response;
    }

}