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
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class Usuario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbUsuario';

    public function parserItens(array $itens = array())
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                $id = $itens[$key]['idUsuario'];
                switch (true) {
                    case $iten instanceof \DateTime:
                        $itens[$key][$keyIten] = $iten->format('d/m/Y');
                        break;
                    case $keyIten == 'stAtivo':
                        $itens[$key][$keyIten] = $iten == 1 ? 'Ativo' : 'Inativo';
                        break;
                }
                $itens[$key]['editar'] = "<a  href='/super/usuario/edit?id=$id'>Editar</a>";
            }
        }
        return $itens;
    }

    public function preInsert(AbstractEntity $entity = null)
    {

        if ($this->getRequest()->request->getInt("tpPessoa") == 2) {
            $entityPessoa = $this->getService('service.pessoa_juridica')->save();
        } else {
            $entityPessoa = $this->getService('service.pessoa_fisica')->save();
        }
        $this->entity->setIdPessoa($entityPessoa->getIdPessoa());
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setStAtivo(false);
        $this->entity->setNoSenha(md5($this->entity->getNoSenha()));
    }


    public function postUpdate(AbstractEntity $entity = null)
    {

        $this->entity->setDtAtualizacao(new \DateTime());
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $hash = $this->generateToken($this->entity);

        $view = 'SiteBundle:Usuario:email-confirmacao.html.twig';
        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'entity' => $this->entity,
                'hash'   => $hash
            ));
        $this->savePerfil();

        return $this->sendMail($this->entity->getNoEmail(), 'Confirmação de cadastro - Bee Imóveis', $body);
    }

    public function savePerfil()
    {
        if ($this->entity->getIdUsuario()) {
            $svUsuarioPerfil = $this->getService('service.super_usuario_perfil');

            foreach ($svUsuarioPerfil->findByIdUsuario($this->entity->getIdUsuario()) as $perfilOld) {
                $this->remove($perfilOld);
            }

            switch($this->getRequest()->request->getInt("tpPessoa")){
                case 2:
                    $perfil = $this->getService('service.super_perfil')->findOneBySgPerfil('ROLE_IMOBILIARIA');
                    break;
                case 3:
                    $perfil = $this->getService('service.super_perfil')->findOneBySgPerfil('ROLE_CORRETOR');
                    break;
                default:
                    $perfil = $this->getService('service.super_perfil')->findOneBySgPerfil('ROLE_USER');
                    break;
            }

            $usuarioPefil = $svUsuarioPerfil->newEntity();
            $usuarioPefil->setIdUsuario($this->entity);
            $usuarioPefil->setIdPerfil($perfil);
            $usuarioPefil->setDtCadastro(new \DateTime());

            $this->persist($usuarioPefil);
        }
    }

    /**
     * @param TbUsuario $entity
     * @return string
     */
    protected function generateToken(TbUsuario $entity)
    {
        $salt     = substr(base64_encode('salt-password-bee'), 0, 12);
        $crypt    = crypt($entity->getNoSenha(), '$1a$19$' . $salt);
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
        $entity    = $this->find($idUsuario);

        if ($entity && $this->generateToken($entity) == $hash) {
            $entity->setStAtivo(true);
            $this->persist($entity);

            return true;
        }

        return false;
    }

    public function recuperarSenha(TbUsuario $entity)
    {
        $alphabet    = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass        = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

        for ($i = 0; $i < 8; $i++) {
            $n      = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        $randonPass = implode($pass);

        $entity->setNoSenha(md5($randonPass));
        $this->persist($entity);


        $view = 'SiteBundle:Usuario:recuperar-senha.html.twig';
        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'entity' => $this->entity,
                'pass'   => $randonPass
            ));

        return $this->sendMail($entity->getNoEmail(), 'Recuperação de Senha - Bee Imóveis', $body);
    }

//    /**
//     * @param TbUsuario $user
//     * @param Request $request
//     * @return mixed
//     */
//    public function login($user = null, $request = null)
//    {
//
//        $token = new UsernamePasswordToken($user, null, "login_firewall", $user->getRoles());
//        $this->getService("security.context")->setToken($token);
//
//        $event = new InteractiveLoginEvent($request, $token);
//        $this->getService("event_dispatcher")->dispatch("security.interactive_login", $event);
//
//    }
}