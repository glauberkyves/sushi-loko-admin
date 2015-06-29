<?php

namespace Super\ManterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SuperManterBundle:Default:index.html.twig', array('name' => $name));
    }
}
