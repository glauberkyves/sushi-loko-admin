<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 14/07/2015
 * Time: 18:40
 */

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Response;

class AbstractMobile extends CrudController
{
    protected $serviceName = 'service.mobile';
    protected $response = array();

    /**
     * Retorna os dados de uma requisição mobile descriptografados
     * @return object
     */
    public function getRequest()
    {
        return $this->getService('service.token')->token(
            parent::getRequest()->request->get('token')
        );
    }

    /**
     * Retorna token encriptado em ssl
     * @param array $response
     * @return Response
     */
    public function response()
    {
        return new Response($this->getService('service.token')->sendToken($this->response));
    }
}