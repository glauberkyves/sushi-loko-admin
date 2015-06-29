<?php

namespace Super\PromocaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SuperPromocaoBundle:Default:index.html.twig', array('name' => $name));
    }
}
