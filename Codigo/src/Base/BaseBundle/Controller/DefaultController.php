<?php

namespace Base\BaseBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends CrudController
{
    protected $serviceName = '';

    public function getMunicipiosAction(Request $request)
    {
        $arrMunicipio = $this->getService('service.municipio')->getComboDefault(
            array(
                'idEstado' => $request->query->getDigits('estado', 0)
            ),
            array(
                'noMunicipio' => 'asc'
            )
        );

        return $this->renderJson($arrMunicipio);
    }

    public function getBairrosAction(Request $request)
    {
        $arrBairros = $this->getService('service.bairro')->getComboDefault(
            array(
                'idMunicipio' => $request->query->getDigits('municipio', 0)
            ),
            array(
                'noBairro' => 'asc'
            )
        );

        return $this->renderJson($arrBairros);
    }

    public function getDadosCepAction(Request $request)
    {
        $result = array();

        if ($request->query->getDigits('cep')) {
            $result = current($this->getService('service.logradouro')->getDadosCep($request->query->getDigits('cep')));
        }

        return $this->renderJson($result);
    }
}
