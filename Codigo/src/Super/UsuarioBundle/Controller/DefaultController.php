<?php

namespace Super\UsuarioBundle\Controller;

use Base\BaseBundle\Service\Dominio;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.usuario';

    public function indexAction(Request $request)
    {
        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        return parent::indexAction($request);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $request->isMethod('post')) {
            if ($this->save()) {
                return $this->renderJson(array(
                    'valido'    => true,
                    'idUsuario' => $request->request->get('idUsuario'),
                    'noPessoa'  => $request->request->get('noPessoa'),
                    'noEmail'   => $request->request->get('noEmail')
                ));
            } else {
                return $this->renderJson(array(
                    'valido'   => false,
                    'mensagem' => $this->getMessage()
                ));
            }
        }
    }
}
