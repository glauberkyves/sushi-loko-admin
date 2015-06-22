<?php

namespace SiteBundle\Controller;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class UsuarioController extends CrudController
{
    protected $serviceName = 'service.usuario';

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        if ($this->getUser()) {
            return $this->redirect($this->generateUrl('site_homepage'));
        }

        return parent::createAction($request);
    }

    /**
     * @param AbstractEntity $entity
     * @return bool
     */
    public function validate(AbstractEntity $entity = null)
    {
        $request = $this->getRequest();

        if ($this->getService('service.pessoa_fisica')->findByNuCpf($request->request->getDigits('nuCpf'))) {
            $this->addMessage('usuario_bundle.messages.usuario.nuCpfduplicity', 'error');
        }

        if ($this->getService()->findByNoEmail($request->request->get('noEmail'))) {
            $this->addMessage('usuario_bundle.messages.usuario.emaiduplicity', 'error');
        }

        return parent::validate();
    }

    /**
     * @return string
     */
    public function resolveRouteIndex()
    {
        if ($this->get('session')->has('redirect')) {
            return $this->get('session')->get('redirect');
        }

        return $this->generateUrl('site_homepage');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        return $this->render($this->resolveRouteName(), array(
            'error' => $request->getSession()->get(Security::AUTHENTICATION_ERROR)
        ));
    }

    /**
     * @param Request $request
     * @param $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function ativarCadastroAction(Request $request, $token)
    {
        if ($this->getService()->ativarCadastro($token)) {
            $this->addMessage('site_bundle.messages.usuario.activate');
        } else {
            $this->addMessage('site_bundle.messages.usuario.activateError', 'error');
        }

        return $this->redirect($this->generateUrl('site_homepage'));
    }
}
