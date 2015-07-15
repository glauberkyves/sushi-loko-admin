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
     * @param idFranquia, mensagem
     * @return Response
     */
    public function opinarAction()
    {
        $request = $this->getRequest();

        $idFranquia = $this->getService('service.franqueador')->find($request->idFranquia);

        if($idFranquia) {

            $this->getService('service.franquia_opiniao')->adicionar($idFranquia, $request->mensagem);

            $this->add('valido',   true);
            $this->add('mensagem', 'mobile_bundle.franquia.default.error');
        } else {
            $this->add('mensagem', 'mobile_bundle.franquia.default.error');
        }

        return $this->response();
    }
}