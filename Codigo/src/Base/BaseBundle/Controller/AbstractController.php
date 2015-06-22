<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 20/01/15
 * Time: 16:13
 */

namespace Base\BaseBundle\Controller;


use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\AbstractService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AbstractController extends Controller
{
    protected $serviceName = null;

    /**
     * @var AbstractService
     */
    protected $service = null;

    /**
     * Retorna a Service respectiva da Controller
     *
     * @return object
     */
    protected function getService($serviceName = null)
    {
        if (null === $serviceName) {
            $serviceName = $this->serviceName;
        }

        return $this->service = $this->get($serviceName);
    }

    /**
     * Retorna o nome do arquivo twig para renderizar
     *
     * @return mixed
     */
    protected function resolveRouteName($actionName = null)
    {
        $explode    = explode('Controller', $this->getRequest()->attributes->get('_controller'));
        $bundle     = str_replace('\\', '', current($explode));
        $controller = str_replace('\\', '', next($explode));
        $action     = str_replace('::', '', str_replace('Action', '', end($explode)));

        if($actionName){
            $action = $actionName;
        }

        return "{$bundle}:{$controller}:{$action}.html.twig";
    }

    /**
     * @return string
     */
    public function resolveRouteIndex()
    {
        $explode                      = explode('_', $this->getRequest()->get('_route'));
        $explode[count($explode) - 1] = 'index';

        return $this->generateUrl(implode('_', $explode));
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }

    /**
     * @param $params
     * @return JsonResponse
     */
    public function renderJson($params, $status = 200)
    {
        return new JsonResponse($params, $status);
    }
}