<?php

namespace SiteBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends CrudController
{
    protected $serviceName = 'service.anuncio';

    public function faleConoscoAction(Request $request)
    {
        $this->serviceName = 'service.newsletter';

        if ($request->isMethod('post') && $this->validate()) {
            $this->save();
        }

        return $this->render('BaseBaseBundle:Default:faleConosco.html.twig');
    }
}
