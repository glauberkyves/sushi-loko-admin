<?php

namespace Super\FeedbackBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeedbackController extends CrudController
{
    protected $serviceName = 'service.feedback';

    public function emailAction()
    {
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $email = $this->getService('service.feedback_email')->findOneByIdFranqueador($idFranqueador);

        return $this->render('SuperFeedbackBundle:Feedback:email.html.twig', array("franqueador" => $email));
    }

    public function setEmailFeedBackAction(Request $request)
    {
        $mensagem = $request->request->get("emailFaadback");
        $this->getService('service.feedback_email')->registerEmailFaadBack($mensagem);
        $this->addMessage("Operação realizada com sucesso");

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    public function relatorioAction(Request $request, $id)
    {
        $arrGrafico1 = $this->getService('service.feedback')->getGrafico($id, 1);
        $arrGrafico2 = $this->getService('service.feedback')->getGrafico($id, 2);
        $arrGrafico3 = $this->getService('service.feedback')->getGrafico($id, 3);

        $this->vars['mensagens'] = $this->getService('service.feedback')->getMensagens($id);
        $this->vars['relatorio'] = $this->getService('service.feedback')->getRelatorio($id);
        $this->vars['jsonMedia'] = array(
            $this->formatGraph($arrGrafico1),
            $this->formatGraph($arrGrafico2),
            $this->formatGraph($arrGrafico3)
        );

        return $this->render($this->resolveRouteName(), $this->vars);
    }

    private function formatGraph($arrGrafico = array())
    {
        $arrMedia = array();
        foreach($arrGrafico as $grafico) {
            $arrMedia[] = array(
                'media' => $grafico['media'],
                'data'  => $grafico['dtCadastro']->format('Y-m-d')
            );
        }
        return json_encode($arrMedia);
    }
}