<?php

namespace Super\SecurityBundle\Security;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

class LoginErrorHandler implements AuthenticationFailureHandlerInterface
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

    /**
     * This is called when an interactive authentication attempt fails. This is
     * called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response The response to return, never null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array('error' => true));
        } else {
            return new RedirectResponse($this->container->get('router')->generate('site_login'));
        }
    }
}