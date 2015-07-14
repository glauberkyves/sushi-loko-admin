<?php

namespace Super\FranquiaBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Base\BaseBundle\Service\Dominio;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.franquia';

    /**
     * Página inicial do franqueado
     * @param Request $request
     * @param null $idFranqueador
     * @return Response
     */
    public function indexAction(Request $request, $idFranqueador = null)
    {
        $security = $this->get('security.authorization_checker');

        switch(true) {
            case $security->isGranted('ROLE_FRANQUEADOR'):
                $idFranqueador = $this->getService('service.franqueador')->findOneByIdUsuario($this->getUser());
                $this->vars['idFranqueador'] = $idFranqueador->getIdFranqueador();
                break;
            case $security->isGranted('ROLE_SUPER'):
                $this->vars['idFranqueador'] = $idFranqueador;
                break;
        }

        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        return parent::indexAction($request);
    }

    /**
     * Cadastro do franqueado
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request, $idFranqueador = null)
    {
        $this->vars = $this->getService()->getCombos($idFranqueador);

        return parent::createAction($request);
    }

    /**
     * Edição do franqueado
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request)
    {
        $this->vars = $this->getService()->getCombos();

        return parent::editAction($request);
    }

    /**
     * Buscar usuário por nome ou email
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function buscarUsuarioAction()
    {
        $response = $this->getService()->buscarUsuario();

        return $this->renderJson($response);
    }

    /**
     * Busca localidade dos usuários
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function localidadeAction()
    {
        $franquia = $this->getService('service.franqueador')->selectLocalidade();
        return $this->renderJson($franquia);
    }

    /**
     * Configura nova index após uma operação
     * @return string
     */
    public function resolveRouteIndex()
    {
        $security = $this->get('security.authorization_checker');

        switch(true)
        {
            case $security->isGranted('ROLE_FRANQUEADOR'):
                $url = $this->generateUrl('super_franqueador_franquia_index', array());
                break;
            case $security->isGranted('ROLE_SUPER'):
                $url = $this->generateUrl('super_franquia_index', array(
                    'idFranqueador' => $this->getRequest()->get('idFranqueador')
                ));
                break;
        }

        return $url;
    }
}