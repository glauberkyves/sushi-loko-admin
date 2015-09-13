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

        $idFranquia = $this->getService('service.franquia')->findOneByIdUsuario($this->getUser());
        $this->getRequest()->query->set('idFranquia', $idFranquia->getIdFranquia());

        return parent::indexAction($request);
    }

    public function createAction(Request $request)
    {
        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        if ($request->isMethod('post') && $this->validate() && $this->save()) {
            if ($request->isXmlHttpRequest()) {
                $this->container->get('session')->getFlashBag()->clear();

                return new JsonResponse(array(
                    'valido'    => true,
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

    public function editAction(Request $request)
    {
        $this->vars['cmbStatus'] = Dominio::getStAtivo();

        return parent::editAction($request);
    }


    /**
     * @param AbstractEntity $entity
     */
    public function validate(AbstractEntity $entity = null)
    {
        $request = $this->getRequest();

        if ($request->request->get('nuCpf') && $this->getService()->findOperador($request)) {
            $this->addMessage('Usuário já cadastrado', 'error');

            return false;
        }

        return parent::validate($entity);
    }

    public function utilizarCreditoAction(Request $request)
    {
        $params = array();
        if ($request->isMethod('post')) {
            if ($request->request->get('nuCpf') && $request->request->get('noSenha')) {
                $nuCpf         = $request->request->getDigits('nuCpf');
                $noSenha       = $request->request->get('noSenha');
                $idFranquia    = $this->getUser()->getIdFranquiaOperador()->getIdFranquia();
                $idFranqueador = $idFranquia->getIdFranqueador()->getIdFranqueador();

                $user = $this->getService('service.franqueador_usuario')->findUsuarioPorFranqueador(
                    $nuCpf,
                    $idFranqueador
                );

                if ($user) {
                    $srvTransacao           = $this->getService('service.transacao');
                    $srvRequisicaoTransacao = $this->getService('service.requisicao_transacao');

                    $criteria = array(
                        'idUsuario'     => $user,
                        'idFranqueador' => $idFranqueador,
                        'noSenha'       => $noSenha,
                        'stAtivo'       => true,
                        'stUtilizado'   => false
                    );

                    if ($solicitacaoTransacao = $srvRequisicaoTransacao->findOneBy($criteria)) {

                        try {
                            $params['entity']           = $user;
                            $params['nuValor']          = $srvTransacao->getCreditosUsuario($user->getIdUsuario(), $idFranqueador);
                            $params['nuValorUtilizado'] = $solicitacaoTransacao->getNuValor();

                            $srvTransacao->saque($user, $idFranquia, $solicitacaoTransacao->getNuValor());
                            $params['nuValorTotal'] = $srvTransacao->getCreditosUsuario($user->getIdUsuario(), $idFranqueador);

                            $solicitacaoTransacao->setStUtilizado(true);
                            $srvRequisicaoTransacao->persist($solicitacaoTransacao);

                            $this->addMessage('Crédito utilizado com sucesso.');
                        } catch (\Exception $exp) {
                            $this->addMessage('Erro, por favor contate o suporte.', 'error');
                        }
                    } else {
                        $this->addMessage('Solicitação não encontrada.', 'error');
                    }
                } else {
                    $this->addMessage('Cliente não encontrado.', 'error');
                }
            } else {
                $this->addMessage('CPF / Senha obrigatórios.', 'error');
            }
        }

        return $this->render($this->resolveRouteName(), $params);
    }
}