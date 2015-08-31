<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 28/08/2015
 * Time: 14:43
 */

namespace Base\BaseBundle\Service;

use Base\CrudBundle\Service\CrudService;

class Pesquisa extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\Pesquisa';

    public static function getOperador($operador = 'igual')
    {
        switch ($operador) {
            case 'igual': return '=';
            case 'maior': return '>';
            case 'menor': return '<';
            default:      return '=';
        }
    }

    public static function getPeriodo($periodo = 'd')
    {
        switch ($periodo) {
            case 'd': return 'days';
            case 'm': return 'months';
            case 'a': return 'years';
            default:  return 'days';
        }
    }

    public static function getComboSexo()
    {
        return array(
            'm' => 'Masculino',
            'f' => 'Feminino',
            'u' => 'Todos'
        );
    }

    public static function getComboPeriodo()
    {
        return array(
            'd' => 'Dias',
            'm' => 'Meses'
        );
    }

    public static function getComboOperador()
    {
        return array(
            'igual' => 'Igual',
            'maior' => 'Maior',
            'menor' => 'Menor'
        );
    }
}