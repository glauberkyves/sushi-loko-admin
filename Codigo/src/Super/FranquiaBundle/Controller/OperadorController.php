<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 13/07/2015
 * Time: 18:44
 */

namespace Super\FranquiaBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;

class OperadorController extends CrudController
{
    protected $serviceName = 'service.franquia_operador';

    /**
     * @param Request $request
     * @param null $idFranquia
     * @return Response
     */
    public function createAction(Request $request, $idFranquia = null)
    {
        $this->vars['idFranquia'] = $idFranquia;

        return parent::createAction($request);
    }

    /**
     * @param Request $request
     * @param null $idFranquia
     * @return Response
     */
    public function editAction(Request $request, $id = null)
    {
        $this->vars['idFranquia'] = $this->getService('service.franquia')->find($id);

        return parent::editAction($request);
    }

    /**
     * Configura nova index após uma operação
     * @return string
     */
    public function resolveRouteIndex()
    {
        return $this->generateUrl('super_franquia_operador_index', array(
            'idFranquia' => $this->getRequest()->get('idFranquia')
        ));;
    }
}