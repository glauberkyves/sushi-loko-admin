<?php

namespace Super\PromocaoBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class Promocao extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbPromocao';

    public function parserItens(array $itens = array())
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                switch (true) {
                    case $iten instanceof \DateTime:
                        $itens[$key][$keyIten] = $iten->format('d/m/Y');
                        break;
                    case $keyIten == 'stAtivo':
                        $itens[$key][$keyIten] = $iten == 1 ? 'Ativo' : 'Inativo';
                        break;
                }
                $id = $itens[$key]['idPromocao'];
                        $itens[$key]['opcoes'] =  '<div class="modal fade" id="myModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Remover</h4>
      </div>
      <div class="modal-body">
        Deseja Realmente remover essa promoção ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a href="/manter-promocao/delete/' . $id . '" class="btn btn-primary">Remover</a>
      </div>
    </div>
  </div>
</div><button style="margin-right:5px;"data-toggle="modal" data-target="#myModal'.$id.'"  class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></button><a href="/manter-promocao/edit/'.$id.'" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>';
            }
        }
        return $itens;
    }



    public function preSave(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
        $dtValidade = str_replace('/', '-', $this->getRequest()->request->get('dtValidade'));
        $this->entity->setDtValidade(Data::dateBr("$dtValidade 00:00"));
    }

    public function postSave(AbstractEntity $entity = null)
    {
        if ($this->getRequest()->files->get('noImagem')) {
            $path = $this->uploadFile('promocao/' . $this->entity->getIdPromocao(), 'noImagem');

            $this->entity->setNoImagem($path);
            $this->persist($this->entity);
        }
    }


    public function postRemove(AbstractEntity $entity = null)
    {
        $this->addMessage($this->container->get('translator')->trans('base_bundle.messages.success'));
    }

}