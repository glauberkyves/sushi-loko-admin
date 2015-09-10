<?php

namespace Super\FranqueadorBundle\Controller;

use Base\BaseBundle\Entity\TbFranqueadorComentarioUsuario;
use Base\CrudBundle\Controller\CrudController;
use Super\TransacaoBundle\Service\TipoTransacao;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends CrudController
{
    protected $serviceName = 'service.franqueador_usuario';

    public function indexAction(Request $request)
    {
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $request->request->set('idFranqueador', $idFranqueador);

        return parent::indexAction($request);
    }

    public function statusAction(Request $request)
    {
        $idUsuario = $request->get('idUsuario');
        $dsJustificativa = $request->get('dsJustificativa');

        $criteria = array(
            'idUsuario' => $idUsuario,
            'idFranqueador' => $this->getUser()->getIdFranqueador()->getIdFranqueador()
        );
        if ($rlFranqueadorUsuario = $this->getService()->findOneBy($criteria)) {

            $usuario = $rlFranqueadorUsuario->getIdUsuario();

            if ($stAtivo = $rlFranqueadorUsuario->getIdUsuario()->getStAtivo() ? false : true) {
                $this->addMessage('Usuário Ativado com sucesso');
            } else {
                $this->addMessage('Usuário Inativado com sucesso');

                $view = 'SuperFranqueadorBundle:Usuario:emailCancelamento.html.twig';
                $body = $this
                    ->get('templating')
                    ->render($view, array(
                        'entity' => $usuario,
                    ));

                $this
                    ->getService()
                    ->sendMail($usuario->getIdPessoa()->getIdPessoaFisica()->getNoEmail(), 'Cancelamento de cadastro', $body);
            }

            $usuario->setStAtivo($stAtivo);
            $this->getService()->persist($usuario);

            if ($dsJustificativa) {
                $entity = new TbFranqueadorComentarioUsuario();
                $entity->setIdFranqueadorUsuario($rlFranqueadorUsuario);
                $entity->setDsComentario($dsJustificativa);
                $entity->setDtCadastro(new \DateTime());

                $this->getService()->persist($entity);
            }
        } else {
            $this->addMessage('Usuário não encontrado', 'error');
        }

        return $this->redirect($this->generateUrl('super_franqueador_usuario'));
    }

    public function viewAction($idFranqueador, $idUsuario, Request $request)
    {
        $rlFranqueadorUsuario = $this->getService()->findOneBy(
            array(
                'idFranqueador' => $idFranqueador, 'idUsuario' => $idUsuario
            )
        );

        return $this->render($this->resolveRouteName(), array(
            'entity' => $rlFranqueadorUsuario,
            'debito' => TipoTransacao::DEBITO,
        ));
    }
}