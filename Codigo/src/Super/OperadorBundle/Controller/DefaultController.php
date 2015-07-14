<?php

namespace Super\OperadorBundle\Controller;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Dominio;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = 'service.operador';

    public function indexAction(Request $request)
    {
        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        return parent::indexAction($request);
    }

    public function createAction(Request $request)
    {
        if ($request->isMethod('post') && $this->validate() && $this->save()) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(array(
                    'valido' => true,
                    'idUsuario' => $request->request->get('idUsuario'),
                ));
            } else {
                return $this->redirect($this->resolveRouteIndex());
            }
        } else {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(array(
                    'valido'   => false,
                    'mensagem' => $this->getMessage('error'),
                ));
            }
        }

        $this->vars['entity'] = $this->getService()->newEntity()->populate($request->request->all());

        return $this->render($this->resolveRouteName(), $this->vars);
    }


    /**
     * @param AbstractEntity $entity
     */
    public function validate(AbstractEntity $entity = null)
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest() && $this->getService()->findOperador($request)) {
            $this->addMessage('Usuário já cadastrado', 'error');
        }
    }
}
