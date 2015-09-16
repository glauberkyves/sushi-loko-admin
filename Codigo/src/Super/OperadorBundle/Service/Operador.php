<?php

namespace Super\OperadorBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;
use Super\UsuarioBundle\Service\Perfil;

class Operador extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbUsuario';

    public function preInsert(AbstractEntity $entity = null)
    {
        $idPessoaFisica = $this->getService('service.pessoa_fisica')->save();

        $this->entity->setIdPessoa($idPessoaFisica->getIdPessoa());
        $this->entity->setNoSenha('temp');
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setNoLatitude(0);
        $this->entity->setNoLongitude(0);
        $this->entity->setStAtivo(true);
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $this->getService('service.perfil')->savePerfil($this->entity, Perfil::SG_OPERADOR);
        $this->getService('service.franquia_operador')->saveFranquiaOperador($entity);
    }

    public function preUpdate(AbstractEntity $entity = null)
    {
        $request = $this->getRequest()->request;
        $request->set('idPessoa', $this->entity->getIdPessoa()->getIdPessoa());

        $this->getService('service.pessoa_fisica')->save();
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $password = $this->getService('service.usuario')->getRandomHash();
        $view     = 'SuperFranqueadorBundle:Default:envioSenha.html.twig';

        $this->entity->setNoSenha(md5($password));

        $this->persist($this->entity);

        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'senha'  => $password,
                'entity' => $this->entity,
            ));

        if ($this->entity->getIdPessoa()->getIdPessoaFisica()->getNoEmail()) {
            $this->sendMail($this->entity->getIdPessoa()->getIdPessoaFisica()->getNoEmail(), 'Confirmação de cadastro', $body);
        }

        $this->getRequest()->request->set('idUsuario', $this->entity->getIdUsuario());
    }
}