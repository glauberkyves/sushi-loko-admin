<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 14/07/2015
 * Time: 16:47
 */

namespace Super\FranqueadorBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Entity\TbFranqueadorOperador;
use Base\BaseBundle\Entity\TbUsuario;
use Base\CrudBundle\Service\CrudService;
use Super\UsuarioBundle\Service\Perfil;

class FranqueadorOperador extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranqueadorOperador';

    public function preInsert(AbstractEntity $entity = null)
    {
        $idPessoaFisica = $this->getService('service.pessoa_fisica')->save();

        $usuario = new TbUsuario();
        $usuario->setIdPessoa($idPessoaFisica->getIdPessoa());
        $usuario->setNoSenha('temp');
        $usuario->setDtCadastro(new \DateTime());
        $usuario->setNoLatitude(0);
        $usuario->setNoLongitude(0);
        $usuario->setStAtivo(true);

        $this->persist($usuario);

        $this->entity->setIdFranqueador($this->getUser()->getIdfranqueador());
        $this->entity->setIdOperador($usuario);
        $this->entity->setDtCadastro(new \DateTime());
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $this->getService('service.perfil')->savePerfil($this->entity->getIdOperador(), Perfil::SG_OPERADOR);
    }

    public function preUpdate(AbstractEntity $entity = null)
    {
        $request = $this->getRequest()->request;
        $request->set('idPessoa', $this->entity->getIdOperador()->getIdPessoa()->getIdPessoa());
        $request->set('idUsuario', $this->entity->getIdOperador()->getIdUsuario());

        $this->getService('service.pessoa')->save();
        $this->getService('service.pessoa_fisica')->save();
        $this->getService('service.usuario')->save();
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $password = $this->getService('service.usuario')->getRandomHash();
        $view = 'SuperFranqueadorBundle:Default:envioSenha.html.twig';

        $this->entity->getIdOperador()->setNoSenha(md5($password));

        $this->persist($this->entity);

        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'senha' => $password,
                'entity' => $this->entity->getIdOperador(),
            ));

        if ($this->entity->getIdOperador()->getIdPessoa()->getIdPessoaFisica()->getNoEmail()) {
            $this->sendMail(
                $this->entity->getIdOperador()->getIdPessoa()->getIdPessoaFisica()->getNoEmail(),
                'Confirmação de cadastro',
                $body
            );
        }

        $this->getRequest()->request->set('idUsuario', $this->entity->getIdOperador());
    }
}