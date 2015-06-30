<?php

namespace Super\CardapioBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;
class Cardapio extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbCardapio';

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
                $id = $itens[$key]['idCardapio'];
                $itens[$key]['opcoes'] = '<div class="modal fade" id="myModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Remover</h4>
      </div>
      <div class="modal-body">
        Deseja Realmente remover esse Cardapio ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a href="/manter-cardapio/delete/' . $id . '" class="btn btn-primary">Remover</a>
      </div>
    </div>
  </div>
</div><button style="margin-right:5px;"data-toggle="modal" data-target="#myModal'.$id.'"  class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></button><a href="/manter-cardapio/edit/' . $id . '" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>';
            }
        }
        return $itens;
    }


    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());

    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $total = $this->getRequest()->request->get("TotalProdutos");

        for ($i = 1; $i <= $total; $i++) {
            $entidade = $this->getService('service.produto')->newEntity();
            $entidade->setIdCardapio($this->entity);

            $noProduto = $this->getRequest()->request->get("noProduto" . $i);
            $noPreco = $this->getRequest()->request->get("noPreco" . $i);

            if ($this->getRequest()->files->get('noImagem'.$i)) {
                $path = $this->uploadFile('produto/' .$i, 'noImagem'.$i);

                $entidade->setNoImagem($path);
            }

            if ($noProduto) {
                $entidade->setDtCadastro(new \DateTime());
                $entidade->setNoProduto($noProduto);
                $entidade->setNuValor($noPreco);
                $this->persist($entidade);
            }
        }
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $ActionUpdate = $this->getRequest()->request->get("updateProduto");

        if ($ActionUpdate) {
            $total = $this->getRequest()->request->get("total");

            for ($i = 1; $i <= $total; $i++) {

                $id = $this->getRequest()->request->get("idProduto".$i);

                $entidade = $this->getService('service.produto')->find($id);


                if ($entidade) {
                    $noProduto = $this->getRequest()->request->get("noProduto" . $i);
                    $noPreco   = $this->getRequest()->request->get("noPreco" . $i);

                    if ($this->getRequest()->files->get('noImagem'.$i)) {
                        $path = $this->uploadFile('produto/' .$i, 'noImagem'.$i);

                        $entidade->setNoImagem($path);
                    }
                    $entidade->setNoProduto($noProduto);
                    $entidade->setNuValor($noPreco);
                    $this->persist($entidade);
                }
            }
        }
    }
}