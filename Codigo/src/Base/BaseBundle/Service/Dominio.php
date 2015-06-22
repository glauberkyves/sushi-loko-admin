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

    CONST NASCENTE = 1;
    CONST PERPENDICULAR = 2;
    CONST POENTE = 3;
    CONST MASCULINO = 1;
    CONST FEMININO = 2;

    public static function getStAtivo()
    {
        return array(
            ''            => 'Selecione',
            self::INATIVO => 'Inativo',
            self::INATIVO => 'Ativo'
        );
    }

    public static function getPosicaoSol()
    {
        return array(
            ''                  => 'Selecione',
            self::NASCENTE      => 'Nascente',
            self::PERPENDICULAR => 'Perpendicular',
            self::POENTE        => 'Poente'
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