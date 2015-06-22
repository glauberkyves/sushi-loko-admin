<?php

namespace SiteBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends CrudController
{
    protected $serviceName = 'service.anuncio';

    public function mudarEstadoAction(Request $request)
    {
        $idEstado = $this->getService('service.estado')->find($request->get('estado', 0));

        if ($idEstado) {
            $request->getSession()->set('idEstado', $idEstado->getIdEstado());
            $request->getSession()->set('noEstado', $idEstado->getNoEstado());

            setcookie('idEstado', $idEstado->getIdEstado(), (time() + 3600 * 24 * 7), "/"); // 86400 = 1 day}
            setcookie('noEstado', $idEstado->getNoEstado(), (time() + 3600 * 24 * 7), "/"); // 86400 = 1 day}
        }

        return new RedirectResponse($request->headers->get('referer'));
    }

    public function faleConoscoAction(Request $request)
    {
        $this->serviceName = 'service.newsletter';

        if ($request->isMethod('post') && $this->validate()) {
            $this->save();
        }

        return $this->render('BaseBaseBundle:Default:faleConosco.html.twig');
    }
}
