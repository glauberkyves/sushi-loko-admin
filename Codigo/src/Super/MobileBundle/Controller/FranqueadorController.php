<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 15/07/2015
 * Time: 11:14
 */
namespace Super\MobileBundle\Controller;

class FranqueadorController extends AbstractMobile
{
    /**
     * Listar lojas de um franqueador
     * @param idFranqueador
     * @return Response
     */
    public function listarLojasAction()
    {
        $request = $this->getRequest();

        $arrCidades    = $this->getService('service.franqueador')->findCidades($request->idFranqueador);
        $idFranqueador = $this->getService('service.franqueador')->find($request->idFranqueador);

        if($idFranqueador) {

            $arrResponse = array();

            foreach($arrCidades as $key => $cidade)
            {
                $arrFranquia = $this->getService('service.franqueador')->findFranquiasByMunicipio(
                    $request->idFranqueador,
                    $cidade['idMunicipio']
                );

                $arrResponse[$key] = array(
                    'idMunicipio'  => $cidade['idMunicipio'],
                    'noMunicipio'  => $cidade['noMunicipio'],
                    'arrFranquias' => $arrFranquia
                );
            }

            $this->add('valido', true);
            $this->add('franquias', $arrResponse);
        } else {
            $this->add('mensagem', 'mobile_bundle.franqueador.default.error');
        }

        return $this->response();
    }
}