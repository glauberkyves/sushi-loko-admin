<?php

namespace Super\UsuarioBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;

class Usuario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbUsuario';

    public function preInsert(AbstractEntity $entity = null)
    {
        $idPessoaFisica = $this->getService('service.pessoa_fisica')->save();

        $this->entity->setIdPessoa($idPessoaFisica->getIdPessoa());
        $this->entity->setNoSenha(md5($this->entity->getNoSenha()));
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setStAtivo(true);
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $view = 'SuperUsuarioBundle:Default:emailCadastro.html.twig';
        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'entity' => $this->entity,
            ));

        if ($this->entity->getIdPessoa()->getIdPessoaFisica()->getNoEmail()) {
            $this->sendMail($this->entity->getIdPessoa()->getIdPessoaFisica()->getNoEmail(), 'Confirmação de cadastro', $body);
        }

        $this->getRequest()->request->set('idUsuario', $this->entity->getIdUsuario());
    }

    /**
     * Gerador de hash
     */
    public function getRandomHash($length = 8, $prefix = "", $onlyNumbers = false, $especialChars = false)
    {
        $numbers = preg_replace("/[.| ]/", "", microtime(true));
        for ($i = 0; $i < count($numbers); $i++) {
            if ($numbers{$i} == '1' || $numbers{$i} == '0') {
                $numbers{$i} = mt_rand(2, 9);
            }
        }
        $letters = (!$onlyNumbers)   ? 'abcdefghkmnpqrstuvxwyz' : '';
        $letters .= ($especialChars) ? '/#$%&*()^´[]' : $letters;
        $letters .= (string)$numbers;

        $final = str_split($letters);
        shuffle($final);
        $return = "";
        for ($i = 0; $i < $length; $i++) {
            $return .= $final[mt_rand(0, (int)count($final) - 1)];
        }

        return strtoupper($prefix . $return);
    }
}