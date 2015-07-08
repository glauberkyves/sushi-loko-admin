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

class PessoaFisica extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbPessoaFisica';

    public function preInsert(AbstractEntity $entity = null)
    {
        $entityPessoa = $this
            ->getService('service.pessoa')
            ->save();

        $this->entity->setIdPessoa($entityPessoa);
    }

    public function preSave(AbstractEntity $entity = null)
    {
        $this->entity->setNuCpf($this->getRequest()->request->getDigits('nuCpf'));
    }
}