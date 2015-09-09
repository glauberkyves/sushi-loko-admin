<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 23/01/15
 * Time: 13:51
 */

namespace Base\BaseBundle\Service;

class Data
{
    public static function dateBr($data)
    {
        return new \DateTime(implode("-", array_reverse(explode("/", $data))));
    }

    public static function getComboMes()
    {
        $arrMes = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );

        foreach ($arrMes as $key => $mes) {
            if($key > date('m')) {
                $arrMes[$key] = sprintf("%s de %d", $mes, date("Y",strtotime("-1 year")));
            }
        }

        return $arrMes;
    }
}