<?php

namespace Super\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SuperBaseBundle:Default:index.html.twig');
    }

    public function pesquisaAction()
    {
        return $this->render('SuperBaseBundle:Default:pesquisa.html.twig');
    }
}
