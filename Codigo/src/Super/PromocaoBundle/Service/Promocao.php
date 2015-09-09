<?php
namespace Super\PromocaoBundle\Service;
use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;
use Symfony\Component\Validator\Validator;
class Promocao extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbPromocao';

    public function preInsert(AbstractEntity $entity = null)
    {
        $dtValidade = $this->getRequest()->request->get('dtValidade');

        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setDtValidade(Data::dateBr($dtValidade));
        $this->entity->setIdFranqueador($this->getUser()->getIdFranqueador());
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

    public function delete($id = 0)
    {
        $idFranqueador      = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $idFranquiaPromocao = $this->getService('service.franquia_promocao')->getByIdFranqueador($id, $idFranqueador);

        if ($idFranquiaPromocao) {
            $this->addMessage(
                sprintf("A franquia \"%s\" está utilizando esta promoção no momento!", $idFranquiaPromocao['noFranquia']),
                "error"
            );
        } else {
            $idPromocao = $this->getService('service.promocao')->findOneBy(
                array(
                    'idFranqueador' => $idFranqueador,
                    'idPromocao' => $id
                )
            );
            if ($idPromocao) {
                if ($this->getService('service.promocao')->remove($idPromocao)) {
                    $this->addMessage('Operação realizada com sucesso!');
                }
            } else {
                $this->addMessage('A promoção informado não existe!', 'error');
            }
        }
    }
}