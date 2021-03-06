<?php

namespace Super\PromocaoBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PromocaoController extends CrudController
{
    protected $serviceName = 'service.promocao';

    public function deleteAction(Request $request, $id)
    {
        $this->getService()->delete($id);

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
}
