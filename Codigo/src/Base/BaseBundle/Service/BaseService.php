<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 23/01/15
 * Time: 13:51
 */

namespace Base\BaseBundle\Service;


use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\Exception\CrudServiceException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Validator\Validator;

class BaseService
{
    /**
     * @var EntityManager
     */
    protected $entityManager = null;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        if (null === $this->entityName) {
            throw new CrudServiceException('Necessário informar a entidade principal para uso.');
        }

        $this->entityManager = $container->get("doctrine.orm.entity_manager");
        $this->container     = $container;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param null $entityName
     * @return \Doctrine\ORM\EntityRepository
     */
    public function newEntity($entityName = null)
    {
        if (null === $entityName) {
            $entityName = $this->entityName;
        }

        AbstractEntity::$manageEntity = array();

        return $this->entity = new $entityName();
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        AbstractEntity::$manageEntity = array();

        return $this->entity;
    }

    /**
     *
     * @return object
     */
    protected function getService($serviceName = null)
    {
        if (null === $serviceName) {
            $serviceName = $this->serviceName;
        }

        return $this->container->get($serviceName);
    }

    /**
     * @param string $message
     * @param string $type
     */
    protected function addMessage($message, $type = 'success')
    {
        if ($type == 'error') {
            $this->erros = true;
        }

        $this->container->get('session')->getFlashBag()->add($type, $message);
    }

    /**
     * @param $message
     * @param array $parameters
     * @param string $domain
     * @param null $locale
     * @return mixed
     */
    public function translate($message, array $parameters = array(), $domain = 'validators', $locale = null)
    {
        return $this->container->get('translator')->trans($message, $parameters, $domain, $locale);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return \Swift_Mailer
     */
    public function getMailer()
    {
        return $this->getContainer()->get('mailer');
    }

    /**
     * @param $name
     * @param $arguments
     * @return EntityRepository
     */
    public function __call($name, $arguments)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityName);

        return call_user_func_array(array($repository, $name), $arguments);
    }

    /**
     * @param $toSend
     * @param $subject
     * @param $body
     * @return int
     */
    public function sendMail($toSend, $subject, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setContentType("text/html")
            ->setSubject($subject)
            ->setFrom('no-reply@beeimoveis.com')
            ->setTo($toSend)
            ->setBody($body);

        try {
            return $this->getMailer()->send($message);
        } catch (\Exception $exc) {
            $entity = $this->getService('service.email_error')->newEntity();
            $entity->setDtCadastro(new \DateTime());
            $entity->setNoDestinatario($toSend);
            $entity->setDsMensagem($body);
            $entity->setDsAssunto($subject);
            $entity->setStEnvio(false);

            $this->getService('service.email_error')->persist($entity);

            $this->addLog($exc->getMessage());

            return true;
        }
    }

    /**
     *
     * @param $error
     */
    public function addLog($error)
    {
        $logger = $this->getContainer()->get('logger');
        $logger->error($error);
    }

    /**
     * @param null $entityName
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($entityName = null)
    {
        if (null == $entityName) {
            $entityName = $this->entityName;
        }

        return $this->getEntityManager()->getRepository($entityName);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->getContainer()->get('request_stack')->getCurrentRequest();
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->getContainer()->get('router');
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->getContainer()->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->getContainer()->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }
}