<?php

namespace Super\FeedbackBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeedbackController  extends CrudController
{
    protected $serviceName = 'service.feedback';

    public function emailAction()
    {
        return $this->render('SuperFeedbackBundle:Feedback:email.html.twig');
    }

}
