<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 09/09/2015
 * Time: 15:47
 */

namespace Super\FranquiaBundle\Service;

use Base\CrudBundle\Service\CrudService;

class FranqueadorFranquia extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranqueador';

    public function parserItens(array $itens = array(), $addOptions = true)
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                if ($keyIten == 'noRazaoSocial') {
                    $itens[$key]['noRazaoSocial'] = sprintf('<a href="/administrador/franquia/%s">%s</a>', $itens[$key]['idFranqueador'], $iten);
                }
            }
        }

        return parent::parserItens($itens, $addOptions);
    }
}