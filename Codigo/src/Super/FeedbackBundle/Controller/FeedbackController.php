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
        $idFranqueador = 1;
        $email = $this->getService('service.feedback_email')->findOneByIdFranqueador($idFranqueador);
        $data = array("franqueador" => $email);
        return $this->render('SuperFeedbackBundle:Feedback:email.html.twig', $data);
    }

    public function setEmailFeedBackAction(Request $request)
    {
        $mensagem = $request->request->get("emailFaadback");
        $idFranqueador = 1;
        $this->getService('service.feedback_email')->registerEmailFaadBack($mensagem, $idFranqueador);
        $this->addMessage("Operação realizada com sucesso");
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
}