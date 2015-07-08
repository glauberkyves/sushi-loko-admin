<?php

namespace Super\UsuarioBundle\Service;

use Base\BaseBundle\Entity\RlUsuarioPerfil;
use Base\BaseBundle\Entity\TbUsuario;
use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\Exception\CrudServiceException;
use Symfony\Component\HttpFoundation\Request;

class Usuario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbUsuario';

    public function preInsert(AbstractEntity $entity = null)
    {
        $request    = $this->getRequest();
        $repository = $this->getRepository();

        if ('super_usuario_create_operador' === $request->get('_route') && $repository->findOperador($request)) {
            throw new CrudServiceException('Usuário já cadastrado');
        }

        $idPessoaFisica = $this->getService('service.pessoa_fisica')->save();

        $this->entity->setIdPessoa($idPessoaFisica->getIdPessoa());
        $this->entity->setNoSenha(md5($this->entity->getNoSenha()));
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setStAtivo(true);
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $request = $this->getRequest();

        if ('super_usuario_create_operador' === $request->get('_route')) {
            $this->postSaveOperador();
        }
    }

    public function postSaveOperador()
    {
        $password = $this->getRandomHash();
        $this->entity->setNoSenha(md5($password));

        $this->persist();
        $this->savePerfil(null, Perfil::SG_OPERADOR);
        $this->sendMailCadastro(null, Perfil::SG_OPERADOR);
    }

    public function sendMailCadastro(TbUsuario $entity = null)
    {
        if (null === $entity) {
            $entity = $this->entity;
        }
    }

    public function savePerfil(TbUsuario $entity = null, $sgPerfil)
    {
        if (null === $entity) {
            $entity = $this->entity;
        }

        $entityUsuarioPerfil = new RlUsuarioPerfil();
        $entityUsuarioPerfil->setIdUsuario($entity);
        $entityUsuarioPerfil->setDtCadastro(new \DateTime());

        $entityPerfil = $this->getService('service.perfil')->findOneBySgPerfil($sgPerfil);
        $entityUsuarioPerfil->setIdPerfil($entityPerfil);

        return $this->persist($entityUsuarioPerfil);
    }

    /**
     * Random hash de transação
     */
    public function getRandomHash($length = 8, $prefix = "", $onlyNumbers = false, $especialChars = false)
    {
        $numbers = preg_replace("/[.| ]/", "", microtime(true));
        for ($i = 0; $i < count($numbers); $i++) {
            if ($numbers{$i} == '1' || $numbers{$i} == '0') {
                $numbers{$i} = mt_rand(2, 9);
            }
        }
        if (!$onlyNumbers) {
            $letters = 'abcdefghkmnpqrstuvxwyz';
            $letters .= (string)$numbers;
        } else {
            $letters = (string)$numbers;
        }
        if ($especialChars) {
            $letters .= '/#$%&*()^´[]';
        }
        $final = str_split($letters);
        shuffle($final);
        $return = "";
        for ($i = 0; $i < $length; $i++) {
            $return .= $final[mt_rand(0, (int)count($final) - 1)];
        }

        return strtoupper($prefix . $return);
    }
}