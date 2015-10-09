<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 22/01/15
 * Time: 18:14
 */

namespace SiteBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\TbUsuario;
use Super\TemplateBundle\Service\TipoTemplate;

class Usuario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbUsuario';

    /**
     * @param TbUsuario $entity
     * @return string
     */
    protected function generateToken(TbUsuario $entity)
    {
        $salt = substr(base64_encode('salt-password-bee'), 0, 12);
        $crypt = crypt($entity->getNoSenha(), '$1a$19$' . $salt);
        $identify = '-' . base64_encode($entity->getIdUsuario());

        return md5($crypt) . $identify;
    }

    /**
     * @param $hash
     * @return bool
     */
    public function ativarCadastro($hash)
    {
        $idUsuario = base64_decode(current(array_reverse(explode('-', $hash))));
        $entity = $this->find($idUsuario);

        if ($entity && $this->generateToken($entity) == $hash) {
            $entity->setStAtivo(true);
            $this->persist($entity);

            return true;
        }

        return false;
    }

    public function recuperarSenha(TbUsuario $entity)
    {
        $mail = $entity->getIdPessoa()->getIdPessoaFisica()->getNoEmail();
        $randonPass = $this->getService('service.usuario')->getRandomHash();

        $entity->setNoSenha(md5($randonPass));
        $this->persist($entity);

        $view = 'SiteBundle:Usuario:recuperar-senha.html.twig';
        $html = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'entity' => $entity,
                'pass' => $randonPass
            ));

        $tipoTemplate = TipoTemplate::EsqueciSenha;
        $template = $this->getService('service.template')->findOneByIdTipoTemplate($tipoTemplate);
        $view = 'SuperTemplateBundle:Franqueador:view.html.twig';

        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'entity' => $template,
                'dados' => $html,
            ));

        return $this->sendMail($mail, 'Recuperação de Senha', $body);
    }
}