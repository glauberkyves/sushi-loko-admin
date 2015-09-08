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
}