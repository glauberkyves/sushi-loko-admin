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
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator;

class AbstractService extends BaseService
{
    protected $entityName = null;
    protected $entity = null;
    protected $erros = false;

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity|\Exception
     */
    public function save(AbstractEntity $entity = null, array $params = array())
    {
        if (null === $entity) {
            $this->entity = new $this->entityName;
        } else {
            $this->entity = $entity;
        }

        if (!$params) {
            $params = $this->getRequest()->request->all();
        }

        $metadata = $this->getEntityManager()->getClassMetadata(get_class($this->entity));
        $insert   = false;

        $methodGet = 'get' . ucfirst(current($metadata->getIdentifier()));

        if ($this->entity->{$methodGet}()
            || (array_key_exists(current($metadata->getIdentifier()), $params) && $params[current($metadata->getIdentifier())])
        ) {
            $id = $this->entity->{$methodGet}();

            if (array_key_exists(current($metadata->getIdentifier()), $params) && $params[current($metadata->getIdentifier())]) {
                $id = $params[current($metadata->getIdentifier())];
            }

            $this->entity = $this->find($id);
            $this->entity->populate($params);

        } else {
            $insert = true;

            if (null === $entity) {
                $this->entity = $this->newEntity()->populate($params);
            }
        }

        call_user_func_array(array($this, 'preSave'), array($this->entity, $params));

        if ($insert) {
            call_user_func_array(array($this, 'preInsert'), array($this->entity, $params));
        } else {
            call_user_func_array(array($this, 'preUpdate'), array($this->entity, $params));
        }

        $this->persist($this->entity);

        if ($insert) {
            call_user_func_array(array($this, 'postInsert'), array($this->entity, $params));
        } else {
            call_user_func_array(array($this, 'postUpdate'), array($this->entity, $params));
        }

        call_user_func_array(array($this, 'postSave'), array($this->entity, $params));

        return $this->entity;
    }

    public function preSave(AbstractEntity $entity = null)
    {

    }

    public function postSave(AbstractEntity $entity = null)
    {

    }

    public function preInsert(AbstractEntity $entity = null)
    {

    }

    public function postInsert(AbstractEntity $entity = null)
    {

    }

    public function preUpdate(AbstractEntity $entity = null)
    {

    }

    public function postUpdate(AbstractEntity $entity = null)
    {

    }

    public function persist(AbstractEntity $entity = null)
    {
        if (null === $entity) {
            $entity = $this->entity;
        }

        try {
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush($entity);
        } catch (\Exception $exc) {
            throw new CrudServiceException($exc->getMessage());
        }

        return $entity;
    }

    public function remove(AbstractEntity $entity = null)
    {
        $this->preRemove($entity);

        $metadata  = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $methodGet = 'get' . ucfirst(current($metadata->getIdentifier()));

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush($entity);

        $this->postRemove($entity);

        return null === $entity->{$methodGet}() ? true : false;
    }

    public function preRemove(AbstractEntity $entity = null)
    {

    }

    public function postRemove(AbstractEntity $entity = null)
    {

    }
}