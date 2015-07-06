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

    public function createAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $request->isMethod('post')) {
            //if ($this->validate() && $this->save(false)) {
            if(true){
                return $this->renderJson(array(
                    'valido' => true,
                    'idUsuario' => 1,
                    'noPessoa' => 'Glauber Kyves',
                    'noEmail' => 'glauberkyves@gmail.com'
                ));
            }else{
                return $this->renderJson(array(
                    'valido' => false,
                    'mensagem' => $this->getMessage()
                ));
            }
        }
    }
}
