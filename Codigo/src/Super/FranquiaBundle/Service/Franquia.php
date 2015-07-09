<?php

namespace Super\FranquiaBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Service\Dominio;

class Franquia extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranquia';

    public function preSave(AbstractEntity $entity = null)
    {
        $idOperador    = $this->getRequest()->request->getInt('idOperador');
        $idFranqueador = $this->getRequest()->request->getInt('idFranqueador');
        $idCardapio    = $this->getRequest()->request->getInt('idCardapio');

        $idEndereco    = $this->getService('service.endereco')->save();
        $idFranqueador = $this->getService('service.franqueador')->find($idFranqueador);
        $idOperador    = $this->getService('service.usuario')->find($idOperador);
        $idCardapio    = $this->getService('service.cardapio')->find($idCardapio);

        $this->entity->setIdEndereco($idEndereco);
        $this->entity->setIdFranqueador($idFranqueador);
        $this->entity->setIdOperador($idOperador);
        $this->entity->setIdCardapio($idCardapio);
    }

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $arrPromocao         = $this->getRequest()->request->get('idPromocao');
        $srvFranquiaPromocao = $this->getService('service.franquia_promocao');
        $arrFranquiaPromocao = $srvFranquiaPromocao->findByIdFranquia(
            $this->getRequest()->request->get('idFranquia')
        );

        foreach ($arrFranquiaPromocao as $idFranquiaPromocao) {
            $this->remove($idFranquiaPromocao);
        }

        if($arrPromocao)
        {
            foreach($arrPromocao as $key => $idPromocao)
            {
                $entityPromocao = $this->getService('service.promocao')->find($idPromocao);

                $idFranquiaPromocao = $this->getService('service.franquia_promocao')->newEntity();
                $idFranquiaPromocao->setIdFranquia($this->entity);
                $idFranquiaPromocao->setIdPromocao($entityPromocao);

                $this->persist($idFranquiaPromocao);
            }
        }
    }

    /**
     * Autocomplete, busca usuário por email/nome
     * @return array
     */
    public function buscarUsuario()
    {
        $suggestions = array();
        $response['suggestions'] = array(
            array(
                'value' => 'Nenhum resultado encontrado.',
                'data'  => 0
            )
        );

        if($this->getRequest()->get('q') == 'email')
        {
            $noEmail         = $this->getRequest()->request->get('query', '');
            $arrPessoaFisica = $this->getService('service.pessoa_fisica')->getByNoEmail($noEmail);

            if($arrPessoaFisica)
            {
                foreach($arrPessoaFisica as $key => $idPessoaFisica)
                {
                    $suggestions[$key]['noPessoa'] = $idPessoaFisica->getIdPessoa()->getNoPessoa();
                    $suggestions[$key]['value']    = $idPessoaFisica->getNoEmail();
                    $suggestions[$key]['data']     = $idPessoaFisica->getIdPessoa()->getIdPessoa();
                }

                $response['suggestions'] = $suggestions;
            }
        } else {
            $noPessoa        = $this->getRequest()->request->get('query', '');
            $arrPessoaFisica = $this->getService('service.pessoa_fisica')->getByNoPessoa($noPessoa);

            if($arrPessoaFisica)
            {
                foreach($arrPessoaFisica as $key => $idPessoaFisica)
                {
                    $suggestions[$key]['noEmail']  = $idPessoaFisica->getNoEmail();
                    $suggestions[$key]['value']    = $idPessoaFisica->getIdPessoa()->getNoPessoa();
                    $suggestions[$key]['data']     = $idPessoaFisica->getIdPessoa()->getIdPessoa();
                }

                $response['suggestions'] = $suggestions;
            }
        }

        return $response;
    }

    /**
     * Gerar combos para formulário do franqueado
     * @param null $idFranqueador
     * @return array
     */
    public function getCombos($idFranqueador = null)
    {
        $this->vars = array(
            'cmbSituacao'   => Dominio::getStAtivo(),
            'cmbMunicipio'  => array('Selecione'),
            'cmbBairro'     => array('Selecione'),
            'arrCardapio'   => array(),
            'arrPromocao'   => array(),
            'arrEstado'     => array(),
            'arrMunicipio'  => array(),
            'arrBairro'     => array(),
            'arrSituacao'   => array(),
            'idFranqueador' => $idFranqueador
        );

        $this->vars['cmbCardapio'] = $this->getService('service.cardapio')->getComboDefault(
            array('stAtivo'    => true),
            array('noCardapio' => 'ASC')
        );

        $this->vars['cmbPromocao'] = $this->getService('service.promocao')->getComboDefault(
            array('stAtivo'    => true),
            array('noPromocao' => 'ASC')
        );

        //remove primeiro elemento do array preservando chaves
        reset($this->vars['cmbPromocao']);
        unset($this->vars['cmbPromocao'][key($this->vars['cmbPromocao'])]);

        $this->vars['cmbEstado'] = $this->getService('service.estado')->getComboDefault(
            array(),
            array('noEstado' => 'asc')
        );

        //combos formulario de edição
        if ($id = $this->getRequest()->get('id'))
        {
            if ($entity = $this->getRepository()->find($id))
            {
                $idEndereco  = $entity->getIdEndereco();
                $idMunicipio = $idEndereco->getIdMunicipio();

                $this->vars['cmbMunicipio'] = $this->getService('service.municipio')->getComboDefault(
                    array('idEstado' => $idMunicipio->getIdEstado()->getIdEstado())
                );

                $this->vars['cmbBairro'] = $this->getService('service.bairro')->getComboDefault(
                    array('idMunicipio' => $idMunicipio->getIdMunicipio())
                );

                array_push($this->vars['arrEstado']   , $idMunicipio->getIdEstado()->getIdEstado());
                array_push($this->vars['arrMunicipio'], $idMunicipio->getIdMunicipio());
                array_push($this->vars['arrBairro']   , $idEndereco->getIdBairro()->getIdBairro());
                array_push($this->vars['arrCardapio'] , $entity->getIdCardapio()->getIdCardapio());
                array_push($this->vars['arrSituacao'] , $entity->getStAtivo());

                foreach ($entity->getIdFranquiaPromocao() as $idFranquiaPromocao) {
                    array_push($this->vars['arrPromocao'], $idFranquiaPromocao->getIdPromocao()->getIdPromocao());
                }
            }
        }

        return $this->vars;
    }
}