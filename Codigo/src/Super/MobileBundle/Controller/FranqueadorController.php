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

        $idFranqueador = $this->getService('service.franqueador')->find($request->idFranqueador);

        if($idFranqueador) {

            $arrFranquia = array();

            foreach($idFranqueador->getIdFranquia() as $key => $idFranquia) {
                $arrFranquia[$key] = array(
                    'idFranquia' => $idFranquia->getIdFranquia(),
                    'noFranquia' => $idFranquia->getNoFranquia(),
                    'noEnderecoAmigavel' => $idFranquia->getIdEndereco()->getNoEnderecoAmigavel(),
                    'noLongitude' => $idFranquia->getIdEndereco()->getNoLongitude(),
                    'noLatitude' => $idFranquia->getIdEndereco()->getNoLatitude(),
                );
            }

            $this->add('valido',    true);
            $this->add('franquias', $arrFranquia);
        } else {
            $this->add('mensagem', 'mobile_bundle.franqueador.default.error');
        }

        return $this->response();
    }
}