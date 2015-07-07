<?php

namespace Super\FranquiaBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;

class Franquia extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranquia';

    public function preSave(AbstractEntity $entity = null)
    {
        $idResponsavel = $this->getRequest()->request->getInt('idResponsavel');
        $idOperador    = $this->getRequest()->request->getInt('idOperador');
        $idFranqueador = $this->getRequest()->request->getInt('idFranqueador');
        $idCardapio    = $this->getRequest()->request->getInt('idCardapio');

        $idEndereco    = $this->getService('service.endereco')->save();
        $idFranqueador = $this->getService('service.franqueador')->find($idFranqueador);
        $idResponsavel = $this->getService('service.usuario')->find($idResponsavel);
        $idOperador    = $this->getService('service.usuario')->find($idOperador);
        $idCardapio    = $this->getService('service.cardapio')->find($idCardapio);

        $this->entity->setIdEndereco($idEndereco);
        $this->entity->setIdFranqueador($idFranqueador);
        $this->entity->setIdResponsavel($idResponsavel);
        $this->entity->setIdOperador($idOperador);
        $this->entity->setIdCardapio($idCardapio);
    }

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
        $this->entity->setStAtivo(true);
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

        foreach($arrPromocao as $key => $idPromocao)
        {
            $entityPromocao = $this->getService('service.promocao')->find($idPromocao);

            $idFranquiaPromocao = $this->getService('service.franquia_promocao')->newEntity();
            $idFranquiaPromocao->setIdFranquia($this->entity);
            $idFranquiaPromocao->setIdPromocao($entityPromocao);

            $this->persist($idFranquiaPromocao);
        }
    }

    public function buscarUsuario()
    {
        $suggestions = array();
        $response    = array(
            'suggestions' => array(
                array(
                    'value' => 'Nenhum resultado encontrado.',
                    'data'  => 0
                )
            )
        );

        $noEmail         = $this->getRequest()->request->get('query', '');
        $arrPessoaFisica = $this->getService('service.pessoa_fisica')->getByNoEmail($noEmail);

        if($arrPessoaFisica)
        {
            foreach($arrPessoaFisica as $key => $idPessoaFisica)
            {
                $suggestions[$key]['noPessoa'] = "Glauber";
                $suggestions[$key]['value']    = $idPessoaFisica->getNoEmail();
                $suggestions[$key]['data']     = 1;
            }

            $response['suggestions'] = $suggestions;
        }

        return $response;
    }

    public function getCombos()
    {
        $this->vars = array(
            'cmbMunicipio'  => array('Selecione'),
            'cmbBairro'     => array('Selecione'),
            'arrCardapio'   => array(),
            'arrPromocao'   => array(),
            'arrEstado'     => array(),
            'arrMunicipio'  => array(),
            'arrBairro'     => array(),
            'idFranqueador' => $this->getRequest()->get('idFranqueador')
        );

        $this->vars['cmbCardapio'] = $this->getService('service.cardapio')->getComboDefault(
            array('stAtivo' => 1),
            array('noCardapio' => 'ASC')
        );

        $this->vars['cmbPromocao'] = $this->getService('service.promocao')->getComboDefault(
            array('stAtivo' => 1),
            array('noPromocao' => 'ASC')
        );

        //remove primeiro elemento do array preservando chaves
        reset($this->vars['cmbPromocao']);
        unset($this->vars['cmbPromocao'][key($this->vars['cmbPromocao'])]);

        $this->vars['cmbEstado'] = $this->getService('service.estado')->getComboDefault(
            array(),
            array('noEstado' => 'asc')
        );

        //formulario de edição
        if($id = $this->getRequest()->get('id'))
        {
            if($entity = $this->getRepository()->find($id))
            {
                $idEndereco = $entity->getIdEndereco();

                $this->vars['cmbMunicipio'] = $this->getService('service.municipio')->getComboDefault(
                    array('idEstado' => $idEndereco->getIdMunicipio()->getIdEstado()->getIdEstado())
                );

                $this->vars['cmbBairro'] = $this->getService('service.bairro')->getComboDefault(
                    array('idMunicipio' => $idEndereco->getIdMunicipio()->getIdMunicipio())
                );

                array_push($this->vars['arrEstado'], $idEndereco->getIdMunicipio()->getIdEstado()->getIdEstado());
                array_push($this->vars['arrMunicipio'], $idEndereco->getIdMunicipio()->getIdMunicipio());
                array_push($this->vars['arrBairro'], $idEndereco->getIdBairro()->getIdBairro());
                array_push($this->vars['arrCardapio'], $entity->getIdCardapio()->getIdCardapio());

                foreach($entity->getIdFranquiaPromocao() as $idFranquiaPromocao)
                {
                    array_push($this->vars['arrPromocao'], $idFranquiaPromocao->getIdPromocao()->getIdPromocao());
                }
            }
        }

        return $this->vars;
    }
}