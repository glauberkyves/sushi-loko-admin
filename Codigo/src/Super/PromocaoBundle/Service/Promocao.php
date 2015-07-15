<?php
namespace Super\PromocaoBundle\Service;
use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;
use Symfony\Component\Validator\Validator;
class Promocao extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbPromocao';


    public function preSave(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
        $dtValidade =  $this->getRequest()->request->get('dtValidade');
        $this->entity->setDtValidade(Data::dateBr($dtValidade));
    }

    public function postSave(AbstractEntity $entity = null)
    {
        if ($this->getRequest()->files->get('noImagem'))
        {
            $path = $this->uploadFile('promocao/' . $this->entity->getIdPromocao(), 'noImagem');
            $this->entity->setNoImagem($path);
            $this->persist($this->entity);
        }
    }

    public function postRemove(AbstractEntity $entity = null)
    {
        $this->addMessage($this->container->get('translator')->trans('base_bundle.messages.success'));
    }

    public function inativarPromocao($id)
    {
        $entidade = $this->getService('service.promocao')->find($id);
        $entidade->setStAtivo(0);
        $this->persist($entidade);
    }
}