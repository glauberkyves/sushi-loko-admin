<?php

namespace Super\CardapioBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class Cardapio extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbCardapio';

    public function parserItens(array $itens = array(), $addOptions = true)
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
                $itens[$key]['verCardapio'] = '<a href="/super/cardapio/visualizar/' . $id . '" class="btn btn-default">ver +</a>';
            }
        }
        return parent::parserItens($itens, $addOptions);
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

            if ($this->getRequest()->files->get('noImagem' . $i)) {
                $path = $this->uploadFile('produto/' . $i, 'noImagem' . $i);

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
            $idProduto = $this->getRequest()->request->get("idProduto");
            if (empty($idProduto)) {
                $this->addMessage("Um cardapio tem que ter pelo penos um produto.");
            } else {
                $noProduto = $this->getRequest()->request->get("noProduto");
                $noPreco = $this->getRequest()->request->get("noPreco");

                $idCardapio = $this->getService('service.cardapio')->find($this->getRequest()->request->get("idCardapio"));

                foreach ($idCardapio->getIdProduto() as $produto) {
                    if (!in_array($produto->getIdProduto(), $idProduto)) {
                        $this->remove($produto);
                    }
                }
                foreach ($idProduto as $key => $id) {
                    if ($id) {
                        $produto = $this->getService('service.produto')->find($id);
                    } else {
                        $produto = $this->getService('service.produto')->newEntity();
                        $produto->setDtCadastro(new \DateTime());
                        $produto->setIdCardapio($this->entity);
                    }

                    if ($this->getRequest()->files->get('noImagem')) {
                        $path = $this->uploadSingleFile('produto/' . $key, 'noImagem', $key);
                        if ($path) {
                            $produto->setNoImagem($path);
                        }
                    }
                    $produto->setNoProduto($noProduto[$key]);
                    $produto->setNuValor($noPreco[$key]);
                    $this->persist($produto);
                }
            }
        }
    }

    public function uploadSingleFile($folder, $fileInput = null, $key = 0)
    {
        $files = $this->getRequest()->files->get('noImagem');
        if ($file = $files[$key]) {
            $fileName = md5(uniqid() . microtime()) . '.' . $file->getClientOriginalExtension();
            $rootDir = $this->getRequest()->server->get('DOCUMENT_ROOT');
            $path = DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR;
            $file->move($rootDir . $path, $fileName);
            $this->getRequest()->files->remove($fileInput);
            return str_replace('\\', '/', $path . $fileName);
        }
    }
}