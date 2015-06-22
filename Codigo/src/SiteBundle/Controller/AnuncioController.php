<?php

namespace SiteBundle\Controller;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Entity\TbTipoImovel;
use Base\BaseBundle\Service\Dominio;
use Base\CrudBundle\Controller\CrudController;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Bundle\PaginatorBundle\Subscriber\SlidingPaginationSubscriber;
use Super\AnuncioBundle\Service\TipoAnuncio;
use Symfony\Component\HttpFoundation\Request;

class AnuncioController extends CrudController
{
    protected $serviceName = 'service.anuncio';

    /**
     * @param Request $request
     * @param null $idTipoImovel
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        if ($this->getUser()) {
            $this->get('session')->remove('redirect');

            if (!$request->isMethod('post')) {
                $request->getSession()->set('token-galeria', md5(uniqid(microtime())));
            }
        } else {
            $router = $this->getRequest()->get('_route');

            if ($this->get('router')->getRouteCollection()->get($router)) {
                $router = $this->generateUrl($router);
            }

            $this->get('session')->set('redirect', $router);

            return $this->redirect($this->generateUrl('site_login'));
        }

        $this->registerCmb();
        $this->populateEntities();

        return parent::createAction($request);
    }

    private function registerCmb()
    {
        $this->vars['arrTpImovel'] = $this
            ->getService('service.tipo_imovel')
            ->getComboDefault(array(), array('noTipoImovel' => 'asc'));

        $this->vars['arrEstado'] = $this
            ->getService('service.estado')
            ->getComboDefault(array(), array('noEstado' => 'asc'));

        $this->vars['arrCaracteristicaImovel'] = $this
            ->getService('service.imovel_caracteristica')
            ->findAll(array(), array('noImovelCaracteristica' => 'asc'));

        $this->vars['arrPorDoSol']  = Dominio::getPosicaoSol();
        $this->vars['arrMunicipio'] = array('' => 'Selecione');
        $this->vars['arrBairro']    = array('' => 'Selecione');
    }

    private function populateEntities()
    {
        $params = $this->getRequest()->request->all();

        $this->vars['idEndereco'] = $this->getService('service.endereco')->newEntity()->populate($params);
        $this->vars['idImovel']   = $this->getService('service.imovel')->newEntity()->populate($params);
        $this->vars['idAnuncio']  = $this->getService('service.anuncio')->newEntity()->populate($params);
    }

    public function uploadAction(Request $request)
    {
        $response = $this->getService()->uploadFotoAnuncio($request);

        return $this->renderJson($response);
    }

    public function removeImageAction()
    {
        if (!$this->getUser()) {
            return $this->redirect($this->generateUrl('home_page'));
        }

//        $criteria = array(
//            'noUrl'     => $this->getRequest()->get('noUrl'),
//            'noHash'    => $this->getRequest()->get('noHash'),
//            'idUsuario' => $this->getUser()->getIdUsuario()
//        );
//
//        $entity = $this->getService('service.galeria')->findOneBy($criteria);
//
//        if ($entity) {
//            $this->getService('service.galeria')->remove($entity);
//        }

        return $this->renderJson('success', 200);
    }

    public function resolveRouteIndex()
    {
        return $this->generateUrl('site_homepage');
    }

    public function buscarAnuncioAction(Request $request)
    {
        $result                  = $this->getService()->buscarAnuncio($request);
        $paginator               = $result->getPaginationData() + array('items' => $result->getItems());
        $paginator['pagination'] = $result;

        return $this->render($this->resolveRouteName(), $paginator);
    }

    public function detalheAnuncioAction(Request $request, $idAnuncio)
    {
        if (!$idAnuncio) {
            return $this->redirect($this->generateUrl('site_homepage'));
        }

        $posicao = Dominio::getPosicaoSol();
        $entity  = $this->getService()->find($idAnuncio);

        if (!$entity) {
            return $this->redirect($this->generateUrl('site_homepage'));
        }

        $imovelCaracteristica = $this->getService('service.imovel_caracteristica')->findAll();

        $data = array(
            "entity"         => $entity,
            "posicao"        => $posicao,
            "caracteristica" => $imovelCaracteristica
        );

        return $this->render($this->resolveRouteName(), $data);
    }

    public function imoveisVendaAction(Request $request)
    {
        $request->query->set('tipo-imovel', TipoAnuncio::VENDA);

        return $this->buscarAnuncioAction($request);
    }

    public function imoveisAluguelAction(Request $request)
    {
        $request->query->set('tipo-imovel', TipoAnuncio::ALUGUEL);

        return $this->buscarAnuncioAction($request);
    }

    public function meusAnunciosAction(Request $request)
    {
        $id       = $this->getUser()->getIdUsuario();
        $idpessoa = $this->getUser()->getIdPessoa()->getIdPessoa();

        $obterAnuncios  = $this->getService('service.anuncio')->findByIdPessoa($idpessoa);

//        $obterfavoritos = $this->getService('service.favorito')->findAll();
        $obterfavoritos = array();
//        $obterIdUsuario = $this->getService('service.agendarhorario')->obterIdUsuario($id);
        $obterIdUsuario = array();

        $data = array(
            "obteridusuario" => $obterIdUsuario,
            "anuncios"       => $obterAnuncios,
            "arrfavoritos"   => $obterfavoritos
        );

        return $this->render($this->resolveRouteName(), $data);
    }

    public function alertaImoveisAction(Request $request)
    {

        return $this->render($this->resolveRouteName());
    }
}
