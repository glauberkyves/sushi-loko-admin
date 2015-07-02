<?php

namespace Super\CardapioBundle\Controller;

use Base\BaseBundle\Service\Dominio;
use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class CardapioController extends CrudController
{
    protected $serviceName = 'service.cardapio';

    public function verAction(Request $request,$id)
    {
        $cardapio = $this->getService('service.cardapio')->find($id);
         $data = array("cardapio"=>$cardapio);
        return $this->render('SuperCardapioBundle:Cardapio:viewsCardapio.html.twig',$data);
    }

}
