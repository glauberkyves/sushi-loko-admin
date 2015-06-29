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

}