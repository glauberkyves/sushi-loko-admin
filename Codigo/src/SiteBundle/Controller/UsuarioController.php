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

    public function recuperarSenhaAction(Request $request)
    {
        if ($this->getUser()) {
            return $this->redirect('/');
        }

        if ($request->isMethod('post')) {
            $entity = $this->getService('service.pessoa_fisica')->findOneByNoEmail($request->request->get('noEmail'));

            if ($entity && $this->getService('service.site.usuario')->recuperarSenha($entity->getIdPessoa()->getIdUsuario())) {
                $this->addMessage('Sua senha foi enviada para o e-mail indicado');
            } else {
                $this->addMessage('E-mail n&atilde;o cadastrado em nosso sistema', 'error');
            }
        }

        return $this->redirect($this->generateUrl('site_homepage'));
    }
}
