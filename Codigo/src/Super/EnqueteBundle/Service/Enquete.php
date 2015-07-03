<?php

namespace Super\EnqueteBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class Enquete extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbEnquete';

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
                $id = $itens[$key]['idEnquete'];
                $itens[$key]['opcoes'] = '<div class="modal fade" id="myModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Remover</h4>
      </div>
      <div class="modal-body">
        Deseja Realmente remover essa enquete ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a href="/super/enquete/manter-enquete/delete/' . $id . '" class="btn btn-primary">Remover</a>
      </div>
    </div>
  </div>
</div><button style="margin-right:5px;"data-toggle="modal" data-target="#myModal'.$id.'"  class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></button><a href="/super/enquete/manter-enquete/edit/' . $id . '" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>';
            }
        }
        return $itens;
    }


    public function preSave(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
        $dtInicio = str_replace('/', '-', $this->getRequest()->request->get('dtInicio'));
        $this->entity->setDtInicio(Data::dateBr("$dtInicio 00:00"));

        $dtFim = str_replace('/', '-', $this->getRequest()->request->get('dtFim'));
        $this->entity->setDtFim(Data::dateBr("$dtFim 00:00"));
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $ActionUpdate = $this->getRequest()->request->get("updateEnquete");
        if ($ActionUpdate) {
            $total = $this->getRequest()->request->get("total");
            for ($i = 1; $i <= $total; $i++) {
                $id = $this->getRequest()->request->get("idResposta".$i);
                $resposta = $this->getRequest()->request->get("resposta".$i);
                $entidade   = $this->getService('service.enquete_resposta')->find($id);

                if ($entidade) {
                    $entidade->setNoResposta($resposta);
                    $this->persist($entidade);
                }
            }
        } else {
            for ($i = 1; $i <= 3; $i++) {
                $entidade = $this->getService('service.enquete_resposta')->newEntity();
                $entidade->setIdEnquete($this->entity);

                $resposta = $this->getRequest()->request->get("resposta" . $i);

                if ($resposta) {
                    $entidade->setNoResposta($resposta);
                    $this->persist($entidade);
                }
            }
        }
    }

    public function postRemove(AbstractEntity $entity = null)
    {
        $this->addMessage($this->container->get('translator')->trans('base_bundle.messages.success'));
    }

}