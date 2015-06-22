<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 22/01/15
 * Time: 18:14
 */

namespace SiteBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;
use Knp\Component\Pager\Paginator;
use Super\AnuncioBundle\Service\TipoAnuncio;
use Symfony\Component\HttpFoundation\Request;

class Anuncio extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbAnuncio';

    public function parserItens(array $itens = array())
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                $id = $itens[$key]['idAnuncio'];
                switch (true) {
                    case $iten instanceof \DateTime:
                        $itens[$key][$keyIten] = $iten->format('d/m/Y');
                        break;
                    case $keyIten == 'stAtivo':
                        $itens[$key][$keyIten] = $iten == 1 ? '<button class="btn btn-success pausar   btndestaque oportunit" name="' . $iten . '"  id=' . $id . '>Ativo</button>' : "<button class='btn btndestaque oportunit pausar' name='$iten'  id='$id'> Inativo</button>";
                        break;
                    case $keyIten == 'nuVisita':
                        $itens[$key][$keyIten] = "<span class='badge badge-sm label-success'>$iten</span>";
                        break;
                    case $keyIten == 'totalGaleria':
                        $itens[$key][$keyIten] = "<span name='$id' class='badge badge-sm label-success verFotos' data-toggle='modal'  data-target='#myModalGaleria'>$iten</span>";
                        break;
                }
            }
            $itens[$key]['editar'] = "<a  href='/super/anuncio/edit?id=$id'>Editar</a>";
        }
        return $itens;
    }

    public function emailResumoAnuncio($anuncios)
    {
        foreach ($anuncios as $anuncio) {
            $email       = $anuncio->getIdPessoa()->getIdUsuario()->getNoEmail();
            $nuVisita    = $anuncio->getNuVisita();
            $numFavorito = count($anuncio->getIdFavorito());

            $view = 'SiteBundle:Site:email-relatorio.html.twig';
            $body = $this
                ->getContainer()
                ->get('templating')
                ->render($view, array(
                    'numeroVisita' => $nuVisita,
                    'numFavorito'  => $numFavorito
                ));

            $this->sendMail($email, 'Relatorio semanal de seu anuncio', $body);
        }

    }

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setNuVisita(0);
        $this->entity->setStAtivo(false);
    }

    public function preSave(AbstractEntity $entity = null)
    {
        $superEdit  = $this->getRequest()->request->get("superAnuncioEdit");

        $entityImovel  = $this->getService('service.imovel')->save();
        $idTipoAnuncio = $this->getRequest()->get('idTipoAnuncio') ? $this->getRequest()->get('idTipoAnuncio') : TipoAnuncio::ALUGUEL;

        if(!$superEdit){
            $idUsuario     = $this->getUser()->getIdUsuario();
            $entityUsuario     = $this->getService('service.usuario')->find($idUsuario);
            $this->entity->setIdPessoa($entityUsuario->getIdPessoa());
        }
        $entityTipoAnuncio = $this->getService('service.tipo_anuncio')->find($idTipoAnuncio);
        $this->entity->setIdImovel($entityImovel);
        $this->entity->setIdTipoAnuncio($entityTipoAnuncio);
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $view = 'SiteBundle:Anuncio:email-anuncio.html.twig';
        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'entity' => $this->entity
            ));

        return $this->sendMail($this->getUser()->getNoEmail(), 'Imovel cadastrado com sucesso', $body);
    }

    public function uploadFotoAnuncio(Request $request)
    {
        ini_set('max_execution_time', -1);

        if ($request->getSession()->has('token-galeria')) {
            $images       = $configs = array();
            $rootDir      = $this->getRequest()->server->get('DOCUMENT_ROOT');
            $tokenGaleria = $request->getSession()->get('token-galeria');
            $path         = '/galeria/' . $tokenGaleria . '/';

            foreach ($request->files->get('galeria') as $key => $file) {
                if ($file) {
                    $fileName = md5(uniqid() . microtime()) . '.' . $file->getClientOriginalExtension();
                    $file->move($rootDir . $path, $fileName);
                }
            }

            foreach (new \DirectoryIterator($rootDir . $path) as $key => $fileInfo) {
                if (!$fileInfo->isDot() && !$fileInfo->isDir()) {
                    $images[$key] = '<img src=' . $path . $fileInfo->getFilename() . ' class="file-preview-image">';

                    $configs[$key]['caption'] = $fileInfo->getFilename();
                    $configs[$key]['width']   = '40px';
                    $configs[$key]['key']     = $key;
                    $configs[$key]['url']     = $this->getService('router')->generate('site_anuncio_remove_foto');
                }
            }

            $response = array(
                'initialPreview'       => $images,
                'initialPreviewConfig' => $configs
            );
        } else {
            $response = array(
                'error' => 'error',
            );
        }

        return $response;
    }

    public function buscarAnuncio(Request $request)
    {
        $result    = $this->getRepository()->buscarAnuncio($request);
        $paginator = $this->getContainer()->get('knp_paginator');

        $page = $request->query->get('page') ? $request->query->get('page') : 1;

        return $paginator->paginate(
            $result,
            $page,
            30
        );
    }

    public function preUpdate(AbstractEntity $entity = null)
    {

    }

    public function pausarAnuncio($id)
    {
        $criteria = array(
            'idPessoa' => $this->getUser()->getIdPessoa()->getIdPessoa(),
            'idAnuncio' => $id
        );
        $anuncio = $this->getRepository()->findOneBy($criteria);
        $anuncio->setStAtivo(false);

        $this->persist($anuncio);

        return array("status" => "pausa", "mensagem" => "Pausado com sucesso.");
    }

    public function playAnuncio($id)
    {
        $criteria = array(
            'idPessoa' => $this->getUser()->getIdPessoa()->getIdPessoa(),
            'idAnuncio' => $id
        );
        $anuncio = $this->getRepository()->findOneBy($criteria);
        $anuncio->setStAtivo(true);

        $this->persist($anuncio);

        return array("status" => "play", "mensagem" => "Puclicado com sucesso.");
    }


    public function superPausarAnuncio($id)
    {
        $criteria = array('idAnuncio' => $id);
        $anuncio = $this->getRepository()->findOneBy($criteria);
        $anuncio->setStAtivo(false);

        $this->persist($anuncio);

        return array("status" => "pausa", "mensagem" => "Pausado com sucesso.");
    }

    public function superPlayAnuncio($id)
    {
        $criteria = array('idAnuncio' => $id);
        $anuncio = $this->getRepository()->findOneBy($criteria);
        $anuncio->setStAtivo(true);

        $this->persist($anuncio);

        return array("status" => "play", "mensagem" => "Puclicado com sucesso.");
    }

    public function inativarImg($id)
    {
        $criteria = array('idGaleria' => $id);
        $galeria = $this->getService('service.galeria')->findOneBy($criteria);
        $galeria->setStAtivo(false);
        $this->persist($galeria);
        return array("status" => "inativada", "mensagem" => "Imagem inativada com sucesso.");
    }

    public function ativarImg($id)
    {
        $criteria = array('idGaleria' => $id);
        $galeria = $this->getService('service.galeria')->findOneBy($criteria);
        $galeria->setStAtivo(true);
        $this->persist($galeria);
        return array("status" => "ativado", "mensagem" => "Imagem ativada com sucesso.");
    }
}