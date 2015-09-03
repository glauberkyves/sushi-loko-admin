<?php

namespace Super\FranqueadorBundle\Controller;

use Base\BaseBundle\Entity\TbFranqueadorComentarioUsuario;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class ComentarioController extends CrudController
{
    protected $serviceName = 'service.franqueador_usuario';

    public function indexAction(Request $request)
    {
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $request->request->set('idFranqueador', $idFranqueador);

        return parent::indexAction($request);
    }

    public function viewComentarioAction(Request $request)
    {
        $this->vars['entity'] = $this->getService()->findOneBy(array(
            'idUsuario'     => $request->get('idUsuario'),
            'idFranqueador' => $request->get('idFranqueador'),
        ));

        if ($request->isMethod('post')) {
            $entity = new TbFranqueadorComentarioUsuario();
            $entity->setIdFranqueadorUsuario($this->vars['entity']);
            $entity->setDsComentario($request->request->get('dsComentario'));
            $entity->setDtCadastro(new \DateTime());

            $this->getService()->persist($entity);

            $this->addMessage('Operação realizada com sucesso');
        }

        return $this->render($this->resolveRouteName(), $this->vars);
    }


}