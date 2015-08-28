<?php

namespace Super\BaseBundle\Controller;

use Base\BaseBundle\Service\Dominio;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class ConfiguracaoFtpController extends CrudController
{
    protected $serviceName = 'service.configuracao_ftp';

    public function indexAction(Request $request)
    {
        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        if ($request->query->has('sEcho') && $request->query->has('sEcho')) {
            return $this->renderJson($this->getService('service.franqueador')->getResultGrid($request));
        }

        return $this->render($this->resolveRouteName(), $this->vars);
    }

    public function createAction(Request $request)
    {
        if ($request->isMethod('post') && $this->validate() && $this->save()) {
            return $this->redirect($this->resolveRouteIndex());
        }

        $idFranqueador = $this->getService('service.franqueador')->find($request->get('id'));

        if (!$idFranqueador) {
            return $this->redirect($this->generateUrl('super_ftp_index'));
        }

        $this->vars['cmbStatus']     = Dominio::getStAtivo();
        $this->vars['noFranqueador'] = $idFranqueador->getNoRazaoSocial();

        if($request->isMethod('post')){
            $this->vars['entity'] = $this->getService()->newEntity()->populate($request->request->all());
        }else{
            $this->vars['entity'] = $idFranqueador->getIdConfiguracaoFtp();
        }

        return $this->render($this->resolveRouteName(), $this->vars);
    }
}
