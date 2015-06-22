<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 22/01/15
 * Time: 18:14
 */

namespace SiteBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;

class Pessoa extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbPessoa';

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setStAtivo(false);
    }

    public function postUpdate(AbstractEntity $entity = null)
    {
        $this->entity->setDtAtualizacao(new \DateTime());
    }
}