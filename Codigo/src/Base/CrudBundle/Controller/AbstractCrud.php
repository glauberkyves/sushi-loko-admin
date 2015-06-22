<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 20/01/15
 * Time: 16:04
 */

namespace Base\CrudBundle\Controller;

use Base\BaseBundle\Controller\AbstractController;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Controller\Exception\CrudException;
use Base\CrudBundle\Service\Exception\CrudServiceException;
use Symfony\Component\Translation\LoggingTranslator;
use Symfony\Component\Validator\Validator;

class AbstractCrud extends AbstractController
{
    protected $serviceName = null;

    public function __construct()
    {
        if (null === $this->serviceName) {
            throw new CrudException('Necessário informar o serviço principal a ser utilizado');
        }
    }

    /**
     * @param $type
     * @return mixed
     */
    public function hasMessage($type)
    {
        return $this->container->get('session')->getFlashBag()->has($type);
    }

    /**
     * @param string $message
     * @param string $type
     */
    protected function addMessage($message, $type = 'success')
    {
        $trans = $this->getTranslator()->trans($message, array());
        $this->container->get('session')->getFlashBag()->add($type, $trans);
    }

    /**
     * @return LoggingTranslator
     */
    public function getTranslator()
    {
        return $this->container->get('translator');
    }

    /**
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function save()
    {
        try {
            $params = $this->getRequest()->request->all();
            $entity = $this->getService()->newEntity()->populate($params, false);

            call_user_func_array(array($this->getService(), 'save'), array($entity));
            $this->addMessage($this->resolveMessageSuccess(), 'success');

            return true;
        } catch (CrudServiceException $exc) {
            $this
                ->get('logger')
                ->error($exc->getTraceAsString());

            $this->addMessage($exc->getMessage(), 'error');

            return false;
        }
    }

    /**
     * @return string
     */
    public function resolveMessageSuccess()
    {
        return 'base_bundle.messages.success';
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return $this->container->get('validator');
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->hasMessage('error');
    }
}