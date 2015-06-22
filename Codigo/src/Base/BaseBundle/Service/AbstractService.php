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
    public function save(AbstractEntity $entity = null)
    {
        if (null === $entity) {
            $this->entity = new $this->entityName;
        } else {
            $this->entity = $entity;
        }

        $params = $this->getRequest()->request->all();
        $metadata  = $this->getEntityManager()->getClassMetadata(get_class($this->entity));
        $arguments = func_get_args();
        $insert    = false;

        $methodGet = 'get' . ucfirst(current($metadata->getIdentifier()));

        if ($this->entity->{$methodGet}()
            || (array_key_exists(current($metadata->getIdentifier()), $params) && $params[current($metadata->getIdentifier())])
        ) {
            $id = $this->entity->{$methodGet}();

            if(array_key_exists(current($metadata->getIdentifier()), $params) && $params[current($metadata->getIdentifier())]){
                $id = $params[current($metadata->getIdentifier())];
            }

            $entityPersister = $this->find($id);
            $entityPersister->populate($params);
        } else {
            $entityPersister = $this->newEntity()->populate($params);
            $insert       = true;
        }

        call_user_func_array(array($this, 'preSave'), array($this->entity));

        if ($insert) {
            call_user_func_array(array($this, 'preInsert'), array($this->entity));
        } else {
            call_user_func_array(array($this, 'preUpdate'), array($this->entity));
        }

        $this->persist($entityPersister);

        $this->entity = $entityPersister;

        if ($insert) {
            call_user_func_array(array($this, 'postInsert'), array($this->entity));
        } else {
            call_user_func_array(array($this, 'postUpdate'), array($this->entity));
        }

        call_user_func_array(array($this, 'postSave'), array($this->entity));

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

    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush($entity);
    }
}