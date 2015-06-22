<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 23/01/15
 * Time: 13:51
 */

namespace Base\BaseBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;

class Newsletter extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbNewsletter';

    public function preInsert(AbstractEntity $entity = null)
    {
        $entity->setDtCadastro(new \DateTime());
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $view = 'BaseBaseBundle:Default:email-newsletter.html.twig';
        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view);

        $noEmail = $this->getContainer()->getParameter('email_fale_conosco');

        return $this->sendMail($noEmail, 'Fale Conosco - Bee Imóveis', $body);
    }
}