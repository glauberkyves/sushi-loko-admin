<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 23/01/15
 * Time: 15:00
 */

namespace Base\BaseBundle\Service;

class Dominio
{
    CONST ATIVO = 1;
    CONST INATIVO = 0;

    CONST MASCULINO = 1;
    CONST FEMININO = 2;

    public static function getStAtivo()
    {
        return array(
            ''             => 'Selecione',
            self::ATIVO    => 'Ativo',
            self::INATIVO  => 'Inativo',
        );
    }

    public static function getStSexo()
    {
        return array(
             ''              => 'Selecione',
            self::MASCULINO => 'Masculino',
            self::FEMININO  => 'Feminino'
        );
    }
}