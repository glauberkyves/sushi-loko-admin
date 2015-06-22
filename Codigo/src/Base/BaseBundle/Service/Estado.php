<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 23/01/15
 * Time: 13:51
 */

namespace Base\BaseBundle\Service;

use Base\CrudBundle\Service\CrudService;

class Estado extends CrudService
{
    CONST BRASILIA = 7;

    protected $entityName = 'Base\BaseBundle\Entity\TbEstado';

    public function getEstadoBrowser()
    {
        $ip  = $this->getContainer()->get('request')->getClientIp();
        $url = "{$this->getContainer()->getParameter('url_geo')}{$ip}";

        $cURL = curl_init($url);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $resultado = curl_exec($cURL);
        curl_close($cURL);

        $result = json_decode($resultado);

        if ($result && isset($result->region)) {
            $estado = utf8_decode($result->region);

            return $this->getRepository()->getEstadoBrowser($estado);
        } else {
            return $this->getRepository()->find(self::BRASILIA);
        }
    }

    public static function getEstados()
    {
        return array(
            0  =>
                array(
                    'idEstado' => 1,
                    'noEstado' => 'Acre',
                    'sgUf'     => 'AC',
                ),
            1  =>
                array(
                    'idEstado' => 2,
                    'noEstado' => 'Alagoas',
                    'sgUf'     => 'AL',
                ),
            2  =>
                array(
                    'idEstado' => 3,
                    'noEstado' => 'Amazonas',
                    'sgUf'     => 'AM',
                ),
            3  =>
                array(
                    'idEstado' => 4,
                    'noEstado' => 'Amapá',
                    'sgUf'     => 'AP',
                ),
            4  =>
                array(
                    'idEstado' => 5,
                    'noEstado' => 'Bahia',
                    'sgUf'     => 'BA',
                ),
            5  =>
                array(
                    'idEstado' => 6,
                    'noEstado' => 'Ceará',
                    'sgUf'     => 'CE',
                ),
            6  =>
                array(
                    'idEstado' => 7,
                    'noEstado' => 'Distrito Federal',
                    'sgUf'     => 'DF',
                ),
            7  =>
                array(
                    'idEstado' => 8,
                    'noEstado' => 'Espírito Santo',
                    'sgUf'     => 'ES',
                ),
            8  =>
                array(
                    'idEstado' => 9,
                    'noEstado' => 'Goiás',
                    'sgUf'     => 'GO',
                ),
            9  =>
                array(
                    'idEstado' => 10,
                    'noEstado' => 'Maranhão',
                    'sgUf'     => 'MA',
                ),
            10 =>
                array(
                    'idEstado' => 11,
                    'noEstado' => 'Minas Gerais',
                    'sgUf'     => 'MG',
                ),
            11 =>
                array(
                    'idEstado' => 12,
                    'noEstado' => 'Mato Grosso do Sul',
                    'sgUf'     => 'MS',
                ),
            12 =>
                array(
                    'idEstado' => 13,
                    'noEstado' => 'Mato Grosso',
                    'sgUf'     => 'MT',
                ),
            13 =>
                array(
                    'idEstado' => 14,
                    'noEstado' => 'Pará',
                    'sgUf'     => 'PA',
                ),
            14 =>
                array(
                    'idEstado' => 15,
                    'noEstado' => 'Paraíba',
                    'sgUf'     => 'PB',
                ),
            15 =>
                array(
                    'idEstado' => 16,
                    'noEstado' => 'Pernambuco',
                    'sgUf'     => 'PE',
                ),
            16 =>
                array(
                    'idEstado' => 17,
                    'noEstado' => 'Piauí',
                    'sgUf'     => 'PI',
                ),
            17 =>
                array(
                    'idEstado' => 18,
                    'noEstado' => 'Paraná',
                    'sgUf'     => 'PR',
                ),
            18 =>
                array(
                    'idEstado' => 19,
                    'noEstado' => 'Rio de Janeiro',
                    'sgUf'     => 'RJ',
                ),
            19 =>
                array(
                    'idEstado' => 20,
                    'noEstado' => 'Rio Grande do Norte',
                    'sgUf'     => 'RN',
                ),
            20 =>
                array(
                    'idEstado' => 21,
                    'noEstado' => 'Rondônia',
                    'sgUf'     => 'RO',
                ),
            21 =>
                array(
                    'idEstado' => 22,
                    'noEstado' => 'Roraima',
                    'sgUf'     => 'RR',
                ),
            22 =>
                array(
                    'idEstado' => 23,
                    'noEstado' => 'Rio Grande do Sul',
                    'sgUf'     => 'RS',
                ),
            23 =>
                array(
                    'idEstado' => 24,
                    'noEstado' => 'Santa Catarina',
                    'sgUf'     => 'SC',
                ),
            24 =>
                array(
                    'idEstado' => 25,
                    'noEstado' => 'Sergipe',
                    'sgUf'     => 'SE',
                ),
            25 =>
                array(
                    'idEstado' => 26,
                    'noEstado' => 'São Paulo',
                    'sgUf'     => 'SP',
                ),
            26 =>
                array(
                    'idEstado' => 27,
                    'noEstado' => 'Tocantins',
                    'sgUf'     => 'TO',
                ),
        );
    }
}