<?php
namespace Super\TemplateBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;
use Symfony\Component\Validator\Validator;

class Template extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbTemplateEmail';

    public function preSave(AbstractEntity $entity = null)
    {
        $idTipoTemplate = $this->getRequest()->request->get('idTipoTemplate');
        $entityTipoTemplate = $this->getService('service.tipo_template')->find($idTipoTemplate);

        $this->entity->setIdTipoTemplate($entityTipoTemplate);
        $this->entity->setIdFranqueador($this->getUser()->getIdFranqueador());
    }

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
    }
}