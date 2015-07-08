<?php

namespace Super\FeedbackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SuperFeedbackBundle:Default:index.html.twig', array('name' => $name));
    }
}
