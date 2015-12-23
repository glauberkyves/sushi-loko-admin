<?php

namespace Super\FranquiaBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Entity\TbUsuario;
use Base\BaseBundle\Service\Mask;
use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Service\Dominio;
use Super\TemplateBundle\Service\TipoTemplate;
use Super\UsuarioBundle\Service\Perfil;

class Franquia extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbFranquia';

    public function preSave(AbstractEntity $entity = null)
    {
        $idFranqueador = $this->getRequest()->request->getInt('idFranqueador');

        $idUsuario = $this->getService('service.usuario')->save();
        $idEndereco = $this->getService('service.endereco')->save();
        $idFranqueador = $this->getService('service.franqueador')->find($idFranqueador);

        $this->entity->setIdUsuario($idUsuario);
        $this->entity->setIdEndereco($idEndereco);
        $this->entity->setIdFranqueador($idFranqueador);
    }

    public function preInsert(AbstractEntity $entity = null)
    {
        $this->entity->setDtCadastro(new \DateTime());
    }

    public function postInsert(AbstractEntity $entity = null)
    {
        $this->editUsuario($this->entity->getIdUsuario());
    }

    public function postSave(AbstractEntity $entity = null)
    {
        $this->savePromocao();
        $this->saveCardapio();
    }

    /**
     * Alterar senha do usuário e enviar por email
     */
    public function editUsuario(TbUsuario $usuario = null)
    {
        $password = $this->getService('service.usuario')->getRandomHash();
        $view = 'SuperFranquiaBundle:Default:envioSenha.html.twig';

        $usuario->setNoSenha(md5($password));

        $this->persist($usuario);

        $html = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'senha' => $password,
                'entity' => $usuario,
            ));

        $tipoTemplate = TipoTemplate::CadastroFranquia;
        $template = $this->getService('service.template')->findOneByIdTipoTemplate($tipoTemplate);
        $view = 'SuperTemplateBundle:Franqueador:view.html.twig';

        $body = $this
            ->getContainer()
            ->get('templating')
            ->render($view, array(
                'entity' => $template,
                'dados' => $html,
            ));

        if ($email = $usuario->getIdPessoa()->getIdPessoaFisica()->getNoEmail()) {
            $this->sendMail(
                $email,
                'Senha de acesso',
                $body
            );
        }

        $this->getService('service.perfil')->savePerfil($this->entity->getIdUsuario(), Perfil::SG_FRANQUIA);
    }

    /**
     * Salvar promoção
     */
    public function savePromocao()
    {
        $arrPromocao = $this->getRequest()->request->get('idPromocao');
        $srvFranquiaPromocao = $this->getService('service.franquia_promocao');
        $arrFranquiaPromocao = $srvFranquiaPromocao->findByIdFranquia(
            $this->getRequest()->request->get('idFranquia')
        );

        foreach ($arrFranquiaPromocao as $idFranquiaPromocao) {
            $this->remove($idFranquiaPromocao);
        }

        if ($arrPromocao) {
            foreach ($arrPromocao as $key => $idPromocao) {
                $entityPromocao = $this->getService('service.promocao')->find($idPromocao);

                $idFranquiaPromocao = $this->getService('service.franquia_promocao')->newEntity();
                $idFranquiaPromocao->setIdFranquia($this->entity);
                $idFranquiaPromocao->setIdPromocao($entityPromocao);

                $this->persist($idFranquiaPromocao);
            }
        }
    }

    /**
     * Salvar promoção
     */
    public function saveCardapio()
    {
        $arrCardapio = $this->getRequest()->request->get('idCardapio');
        $srvFranquiaCardapio = $this->getService('service.franquia_cardapio');
        $arrFranquiaCardapio = $srvFranquiaCardapio->findByIdFranquia(
            $this->getRequest()->request->get('idFranquia')
        );

        foreach ($arrFranquiaCardapio as $idFranquiaCardapio) {
            $this->remove($idFranquiaCardapio);
        }

        if ($arrCardapio) {
            foreach ($arrCardapio as $key => $idCardapio) {
                $entityCardapio = $this->getService('service.cardapio')->find($idCardapio);

                $idFranquiaCardapio = $this->getService('service.franquia_cardapio')->newEntity();
                $idFranquiaCardapio->setIdFranquia($this->entity);
                $idFranquiaCardapio->setIdCardapio($entityCardapio);

                $this->persist($idFranquiaCardapio);
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
                'data' => 0
            )
        );

        if ($this->getRequest()->get('q') === 'email') {
            $noEmail = $this->getRequest()->request->get('query', '');
            $arrPessoaFisica = $this->getService('service.pessoa_fisica')->getByNoEmail($noEmail);

            if ($arrPessoaFisica) {
                foreach ($arrPessoaFisica as $key => $idPessoaFisica) {
                    $suggestions[$key]['noPessoa'] = $idPessoaFisica->getIdPessoa()->getNoPessoa();
                    $suggestions[$key]['value'] = $idPessoaFisica->getNoEmail();
                    $suggestions[$key]['data'] = $idPessoaFisica->getIdPessoa()->getIdUsuario()->getIdUsuario();
                }

                $response['suggestions'] = $suggestions;
            }
        } else {
            $noPessoa = $this->getRequest()->request->get('query', '');
            $arrPessoaFisica = $this->getService('service.pessoa_fisica')->getByNoPessoa($noPessoa);

            if ($arrPessoaFisica) {
                foreach ($arrPessoaFisica as $key => $idPessoaFisica) {
                    $suggestions[$key]['noEmail'] = $idPessoaFisica->getNoEmail();

                    $nomeCpf = $idPessoaFisica->getIdPessoa()->getNoPessoa() . ' - ';
                    $nomeCpf .= Mask::mask($idPessoaFisica->getIdPessoa()->getIdPessoaFisica()->getNuCpf(), '###.###.###-##');

                    $suggestions[$key]['value'] = $nomeCpf;
                    $suggestions[$key]['data'] = $idPessoaFisica->getIdPessoa()->getIdUsuario()->getIdUsuario();
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
            'cmbSituacao' => Dominio::getStAtivo(),
            'cmbMunicipio' => array('Selecione'),
            'cmbBairro' => array('Selecione'),
            'arrCardapio' => array(),
            'arrPromocao' => array(),
            'arrEstado' => array(),
            'arrMunicipio' => array(),
            'arrBairro' => array(),
            'arrSituacao' => array(),
            'idFranqueador' => $idFranqueador
        );

        $this->vars['cmbCardapio'] = $this->getService('service.cardapio')->getComboDefault(
            array('stAtivo' => true),
            array('noCardapio' => 'ASC')
        );

        $this->vars['cmbPromocao'] = $this->getService('service.promocao')->getComboDefault(
            array('stAtivo' => true),
            array('noPromocao' => 'ASC')
        );

        //remove primeiro elemento do array preservando chaves
        reset($this->vars['cmbCardapio']);
        unset($this->vars['cmbCardapio'][key($this->vars['cmbCardapio'])]);

        //remove primeiro elemento do array preservando chaves
        reset($this->vars['cmbPromocao']);
        unset($this->vars['cmbPromocao'][key($this->vars['cmbPromocao'])]);

        $this->vars['cmbEstado'] = $this->getService('service.estado')->getComboDefault(
            array(),
            array('noEstado' => 'asc')
        );

        //combos formulario de edição
        if ($id = $this->getRequest()->get('id')) {
            if ($entity = $this->getRepository()->find($id)) {
                $idEndereco = $entity->getIdEndereco();
                $idMunicipio = $idEndereco->getIdMunicipio();

                $this->vars['cmbMunicipio'] = $this->getService('service.municipio')->getComboDefault(
                    array('idEstado' => $idMunicipio->getIdEstado()->getIdEstado())
                );

                $this->vars['cmbBairro'] = $this->getService('service.bairro')->getComboDefault(
                    array('idMunicipio' => $idMunicipio->getIdMunicipio())
                );

                array_push($this->vars['arrMunicipio'], $idMunicipio->getIdMunicipio());
                array_push($this->vars['arrEstado'], $idMunicipio->getIdEstado()->getIdEstado());
                array_push($this->vars['arrBairro'], $idEndereco->getIdBairro()->getIdBairro());
                array_push($this->vars['arrSituacao'], $entity->getStAtivo());

                foreach ($entity->getIdFranquiaPromocao() as $idFranquiaPromocao) {
                    array_push($this->vars['arrPromocao'], $idFranquiaPromocao->getIdPromocao()->getIdPromocao());
                }

                foreach ($entity->getIdFranquiaCardapio() as $idFranquiaCardapio) {
                    array_push($this->vars['arrCardapio'], $idFranquiaCardapio->getIdCardapio()->getIdCardapio());
                }
            }
        }

        return $this->vars;
    }

    public function parserItens(array $itens = array(), $addOptions = true)
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                if ($keyIten == 'idUsuario') {
                    $user = $this->getService('service.usuario')->find($iten);
                    $itens[$key]['noResponsavel'] = $user->getIdPessoa()->getNoPessoa();
                    $itens[$key]['noEmailResponsavel'] = $user->getIdPessoa()->getIdPessoaFisica()->getNoEmail();
                }
            }
        }

        return parent::parserItens($itens, $addOptions);
    }
}