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

        $idFranquia = $this->getService('service.franqueador')->find($request->idFranquia);
        $idUsuario  = $this->getService('service.usuario')->find($request->idUsuario);

        if($idFranquia) {

            $this->getService('service.franquia_opiniao')->adicionar($idFranquia, $idUsuario, $request->dsMensagem);

            $this->add('valido',   true);
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

        $idFranquia = $this->getService('service.franqueador')->find($request->idFranquia);

        if($idFranquia) {

            $arrPromocao = array();

            foreach($idFranquia->getIdFranquiaPromocao() as $key => $idPromocao) {
                $arrPromocao[$key] = array(
                    'noPromocao' => $idPromocao->getIdPromocao()->getNoPromocao(),
                    'dsPromocao' => $idPromocao->getIdPromocao()->getDsPromocao()
                );
            }

        } else {
            $this->add('mensagem', 'mobile_bundle.franquia.default.error');
        }

        return $this->response();
    }
}