<?php

namespace Super\CardapioBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class Cardapio extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbCardapio';

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setIdFranqueador($this->getUser()->getIdFranqueador());
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $total = $this->getRequest()->request->get("TotalProdutos");

        for ($i = 1; $i <= $total; $i++) {
            $entidade = $this->getService('service.produto')->newEntity();

            $noProduto = $this->getRequest()->request->get("noProduto" . $i);
            $nuPreco   = $this->getRequest()->request->get("noPreco" . $i);
            $nuPreco   = floatval(str_replace(',', '.', str_replace('.', '', $nuPreco)));

            if ($this->getRequest()->files->get('noImagem' . $i)) {
                $path = $this->uploadFile('produto/' . $i, 'noImagem' . $i);
                $entidade->setNoImagem($path);
            }

            $entidade->setIdCardapio($this->entity);
            $entidade->setDtCadastro(new \DateTime());
            $entidade->setNoProduto($noProduto);
            $entidade->setNuValor($nuPreco);

            $this->persist($entidade);
        }
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $actionUpdate = $this->getRequest()->request->get("updateProduto");
        if ($actionUpdate) {
            $idProduto = $this->getRequest()->request->get("idProduto");
            if ($idProduto) {

                $noProduto  = $this->getRequest()->request->get("noProduto");
                $nuPreco    = $this->getRequest()->request->get("noPreco");
                $idCardapio = $this->getRequest()->request->get("idCardapio");
                $idCardapio = $this->getService('service.cardapio')->find($idCardapio);

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
                    $produto->setNuValor(floatval(str_replace(',', '.', str_replace('.', '', $nuPreco[$key]))));
                    $this->persist($produto);
                }
            } else {
                $this->addMessage("Um cardápio tem que ter pelo menos um produto.");
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

    public function delete($id = 0)
    {
        $idFranqueador = $this->getUser()->getIdFranqueador()->getIdFranqueador();
        $idFranquia = $this->getService('service.franquia')->findOneBy(
            array(
                'idFranqueador' => $idFranqueador,
                'idCardapio' => $id
            )
        );

        if ($idFranquia) {
            $this->addMessage(
                sprintf("A franquia \"%s\" está utilizando este cardápio no momento!", $idFranquia->getNoFranquia()),
                "error"
            );
        } else {
            $idCardapio = $this->getService('service.cardapio')->findOneBy(
                array(
                    'idFranqueador' => $idFranqueador,
                    'idCardapio' => $id
                )
            );
            if ($idCardapio) {
                if ($this->getService()->remove($idCardapio)) {
                    $this->addMessage('Operação realizada com sucesso!');
                }
            } else {
                $this->addMessage('O cardápio informado não existe!', 'error');
            }
        }
    }

    public function parserItens(array $itens = array(), $addOptions = true)
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                $id = $itens[$key]['idCardapio'];
                $itens[$key]['verCardapio'] = '<a href="/franqueador/cardapio/visualizar/' . $id . '" class="btn btn-default">ver +</a>';
            }
        }
        return parent::parserItens($itens, $addOptions);
    }
}