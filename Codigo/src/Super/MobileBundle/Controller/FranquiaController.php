<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 15/07/2015
 * Time: 11:14
 */
namespace Super\MobileBundle\Controller;

class FranquiaController extends AbstractMobile
{
    /**
     * Opinar sobre uma franquia
     * @param idFranquia, idUsuario, dsMensagem
     * @return Response
     */
    public function opinarAction()
    {
        $request = $this->getRequest();

        $idFranquia = $this->getService('service.franquia')->find($request->idFranquia);
        $idUsuario  = $this->getService('service.usuario')->find($request->idUsuario);

        if($idFranquia) {

            $this->getService('service.franquia_opiniao')->adicionar($idFranquia, $idUsuario, $request->dsMensagem);

            $this->add('valido', true);
            $this->add('mensagem', 'mobile_bundle.franquia.opinar.success');
        } else {
            $this->add('mensagem', 'mobile_bundle.franquia.default.error');
        }

        return $this->response();
    }

    /**
     * Listar promoções de uma franquia
     * @param idFranquia
     * @return Response
     */
    public function listarPromocaoAction()
    {
        $request = $this->getRequest();

        $idFranquia = $this->getService('service.franquia')->find($request->idFranquia);

        if($idFranquia) {

            $dtAtual = new \DateTime();
            $arrPromocao = array();

            foreach($idFranquia->getIdFranquiaPromocao() as $key => $idFranquiaPromocao) {
                $idPromocao = $idFranquiaPromocao->getIdPromocao();
                if($idPromocao->getStAtivo()) {
                    if($idPromocao->getDtValidade()->format('u') >= $dtAtual->format('u')) {
                        $arrPromocao[$key] = array(
                            'noPromocao' => $idPromocao->getNoPromocao(),
                            'dsPromocao' => $idPromocao->getDsPromocao(),
                            'noImagem'   => $this->getService()->siteURL().$idPromocao->getNoImagem()
                        );
                    }
                }
            }

            if($arrPromocao) {
                $this->add('valido', true);
                $this->add('promocoes', $arrPromocao);
            } else {
                $this->add('mensagem', 'mobile_bundle.franquia.listar_promocao.error');
            }
        } else {
            $this->add('mensagem', 'mobile_bundle.franquia.default.error');
        }

        return $this->response();
    }

    /**
     * Listar cardapio de uma franquia
     * @param idFranquia
     * @return Response
     */
    public function listarCardapioAction()
    {
        $request = $this->getRequest();

        echo '<pre>'; var_dump($request);die;

        $idFranquia = $this->getService('service.franquia')->find($request->idFranquia);

        if($idFranquia) {

            $arrCardapio = $arrProduto = array();
            $idCardapio = $idFranquia->getIdCardapio();

            foreach($idCardapio->getIdProduto() as $key => $idProduto) {
                $arrProduto[$key] = array(
                    'noProduto' => $idProduto->getNoProduto(),
                    'dsProduto' => $idProduto->getDsProduto(),
                    'nuValor'   => $idProduto->getNuValor(),
                    'noImagem'  => $this->getService()->siteURL().$idProduto->getNoImagem()
                );
            }

            //prevendo json quando possuir mais de 1 cardapio
            $arrCardapio[] = array(
                'noCardapio'  => $idCardapio->getNoCardapio(),
                'arrProdutos' => $arrProduto
            );

            if($arrProduto) {
                $this->add('valido', true);
                $this->add('arrCardapio', $arrCardapio);
            } else {
                $this->add('mensagem', 'mobile_bundle.franquia.listar_cardapio.error');
            }
        } else {
            $this->add('mensagem', 'mobile_bundle.franquia.default.error');
        }

        return $this->response();
    }
}