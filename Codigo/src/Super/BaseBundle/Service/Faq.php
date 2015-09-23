<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 23/01/15
 * Time: 13:51
 */

namespace Super\BaseBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;

class Faq extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFaq';

    public function postRemove(AbstractEntity $entity = null)
    {
        $this->addMessage($this->container->get('translator')->trans('base_bundle.messages.success'));
    }

    public function shortText($input, $length) {
    	return ((strlen($input) < $length) ? $x = $input : $x = substr($input, 0, strrpos(substr($input, 0, $length), ' ')) . '...');
    }

    public function parserItens(array $itens = array(), $addOptions = true)
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                switch (true) {
                    case $keyIten == 'noDescricao':
                        $itens[$key][$keyIten] = $this->shortText($iten, 150);
                        break;
                }
            }
        }

        return parent::parserItens($itens);
    }
}