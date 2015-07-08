<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 22/01/15
 * Time: 18:14
 */

namespace Super\UsuarioBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;

class PessoaJuridica extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbPessoaJuridica';

    public function preInsert(AbstractEntity $entity = null)
    {
        $entityPessoa = $this->getService('service.pessoa')->save();

        $this->entity->setIdPessoa($entityPessoa);
    }
}