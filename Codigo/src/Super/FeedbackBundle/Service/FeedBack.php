<?php

namespace Super\FeedbackBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class FeedBack extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFeedback';

    public function parserItens(array $itens = array(), $addOptions = false)
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
                $id = $itens[$key]['idFeedback'];
                $itens[$key]['opcoes'] = '<div class="modal fade" id="myModal' . $id . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Remover</h4>
      </div>
      <div class="modal-body">
        Deseja Realmente remover esse Feed-back?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a href="/super/franqueador/feedback/delete/' . $id . '" class="btn btn-primary">Remover</a>
      </div>
    </div>
  </div>
</div><button style="margin-right:5px;"data-toggle="modal" data-target="#myModal' . $id . '"  class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></button><a href="/super/franqueador/feedback/edit/' . $id . '" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>';
            }
        }
        return parent::parserItens($itens,$addOptions);
    }

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
        $dtInicio = $this->getRequest()->request->get('dtInicio');
        $this->entity->setDtInicio(Data::dateBr($dtInicio));
        $idFranqueador = $this->getService('service.franqueador')->findOneByIdUsuario($this->getUser());
        $this->entity->setIdFranqueador($idFranqueador);
    }
}