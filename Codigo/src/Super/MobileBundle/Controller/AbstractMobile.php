<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 14/07/2015
 * Time: 18:40
 */
namespace Super\MobileBundle\Controller;

use Base\CrudBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Response;

class AbstractMobile extends CrudController
{
    protected $serviceName;
    protected $response;

    public function __construct()
    {
        $this->serviceName = 'service.mobile';
        $this->response = array('valido' => false);
    }

    /**
     * Retorna os dados de uma requisição mobile descriptografados
     * @return object
     */
    public function getRequest()
    {
        return $this->getService('service.token')->token(
            $this->getParentRequest()->request->get('token')
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getParentRequest()
    {
        return parent::getRequest();
    }

    /**
     * Retorna token encriptado em ssl
     * @return Response
     */
    public function response()
    {
        return new Response(
            $this->getService('service.token')->sendToken($this->response)
        );
    }

    /**
     * Adiciona um valor ao array response
     * @param null $key
     * @param null $value
     */
    public function add($key = null, $value = null)
    {
        if($key === 'mensagem') {
            $value = $this->container->get('translator')->trans($value);
        }

        $this->response[$key] = $value;
    }
}