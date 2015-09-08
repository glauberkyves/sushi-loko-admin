<?php

namespace Super\CardapioBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class CardapioController extends CrudController
{
    protected $serviceName = 'service.cardapio';

    public function verAction(Request $request, $id)
    {
        $this->vars['cardapio'] = $this->getService('service.cardapio')->find($id);

        return $this->render('SuperCardapioBundle:Cardapio:viewsCardapio.html.twig', $this->vars);
    }

    public function deleteAction(Request $request, $id)
    {
        $this->getService()->delete($id);

        return $this->redirect($this->resolveRouteIndex());
    }
}
