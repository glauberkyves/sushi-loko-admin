<?php

namespace Super\FranqueadorBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;
use Super\UsuarioBundle\Service\Perfil;

class Franqueador extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranqueador';

    public function preSave(AbstractEntity $entity = null)
    {
        $request = $this->getRequest()->request;

        $this->entity->setNuCnpj($this->getRequest()->request->getDigits('nuCnpj'));
        $this->entity->setNuValorMinimoResgate($request->getDigits('nuValorMinimoResgate'));
        $this->entity->setNuPontosTransacao($request->getDigits('nuPontosTransacao'));
        $this->entity->setNuPorcentagemBonusTransacao($request->getDigits('nuPorcentagemBonusTransacao'));
        $this->entity->setNuValidadeBonus($request->getDigits('nuValidadeBonus'));
        $this->entity->setStNiveis($request->getInt('stNiveis'));

        if ($request->get('idOperador')) {
            $idOperador = $this->getService('service.usuario')->find($request->get('idOperador'));
            $this->entity->setIdOperador($idOperador);
        } else {
            $this->setIdOperador(null);
        }
    }

    public function preInsert(AbstractEntity $entity = null)
    {
        $entityEndereco = $this->getService('service.endereco')->save();
        $entityUsuario  = $this->getService('service.usuario')->save();

        $this->entity->setIdEndereco($entityEndereco);
        $this->entity->setIdUsuario($entityUsuario);

        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setStAtivo(false);
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $usuario  = $this->entity->getIdUsuario();
        $password = $this->getService('service.usuario')->getRandomHash();
        $view     = 'SuperFranqueadorBundle:Default:envioSenha.html.twig';

        $usuario->setNoSenha(md5($password));

        $this->persist($usuario);

        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'senha'  => $password,
                'entity' => $usuario,
            ));

        if ($this->entity->getIdUsuario()->getIdPessoa()->getIdPessoaFisica()->getNoEmail()) {
            $this->sendMail(
                $this->entity->getIdUsuario()->getIdPessoa()->getIdPessoaFisica()->getNoEmail(),
                'Senha de acesso',
                $body
            );
        }

        $this->getService('service.perfil')->savePerfil($this->entity->getIdUsuario(), Perfil::SG_FRANQUEADOR);
    }

    public function preUpdate(AbstractEntity $entity = null)
    {
        $request = $this->getRequest()->request;
        $request->set('idEndereco', $this->entity->getIdEndereco()->getIdEndereco());
        $request->set('idUsuario', $this->entity->getIdUsuario()->getIdUsuario());
        $request->set('idPessoa', $this->entity->getIdUsuario()->getIdPessoa()->getIdPessoa());

        $this->getService('service.endereco')->save();
        $this->getService('service.usuario')->save();
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $this->getService('service.configuracao_franquia_nivel')->saveConfiguracaoNivel($this->entity);
    }
}