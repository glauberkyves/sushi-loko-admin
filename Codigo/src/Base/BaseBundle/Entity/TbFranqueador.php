<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueador
 *
 * @ORM\Table(name="tb_franqueador")
 * @ORM\Entity
 */
class TbFranqueador extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franqueador", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranqueador;

    /**
     * @var TbPessoaJuridica
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbPessoa", mappedBy="idPessoa")
     */
    protected $idPessoa;

    /**
     * @var TbPessoaJuridica
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbEndereco", mappedBy="idPessoa")
     */
    private $idEndereco;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_niveis", type="integer", nullable=false)
     */
    private $stNiveis;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_configuracao_franquia", type="integer", nullable=false)
     */
    private $idConfiguracaoFranquia;

    /**
     * @var integer
     *
     * @ORM\Column(name="no_responsavel", type="string", nullable=false)
     */
    private $noResponsavel;

    /**
     * @var integer
     *
     * @ORM\Column(name="no_email", type="string", nullable=false)
     */
    private $noEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @return int
     */
    public function getIdFranqueador()
    {
        return $this->idFranqueador;
    }

    /**
     * @param int $idFranqueador
     */
    public function setIdFranqueador($idFranqueador)
    {
        $this->idFranqueador = $idFranqueador;
    }

    /**
     * @return TbPessoaJuridica
     */
    public function getIdPessoa()
    {
        return $this->idPessoa ? $this->idPessoa : new TbPessoa();
    }

    /**
     * @param TbPessoaJuridica $idPessoa
     */
    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * @return int
     */
    public function getIdEndereco()
    {
        return $this->idEndereco ? $this->idEndereco : new TbEndereco();
    }

    /**
     * @param int $idEndereco
     */
    public function setIdEndereco($idEndereco)
    {
        $this->idEndereco = $idEndereco;
    }

    /**
     * @return int
     */
    public function getStNiveis()
    {
        return $this->stNiveis;
    }

    /**
     * @param int $stNiveis
     */
    public function setStNiveis($stNiveis)
    {
        $this->stNiveis = $stNiveis;
    }

    /**
     * @return int
     */
    public function getIdConfiguracaoFranquia()
    {
        return $this->idConfiguracaoFranquia;
    }

    /**
     * @param int $idConfiguracaoFranquia
     */
    public function setIdConfiguracaoFranquia($idConfiguracaoFranquia)
    {
        $this->idConfiguracaoFranquia = $idConfiguracaoFranquia;
    }

    /**
     * @return int
     */
    public function getStAtivo()
    {
        return $this->stAtivo;
    }

    /**
     * @param int $stAtivo
     */
    public function setStAtivo($stAtivo)
    {
        $this->stAtivo = $stAtivo;
    }

    /**
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * @param \DateTime $dtCadastro
     */
    public function setDtCadastro($dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
    }

    /**
     * @return int
     */
    public function getNoResponsavel()
    {
        return $this->noResponsavel;
    }

    /**
     * @param int $noResponsavel
     */
    public function setNoResponsavel($noResponsavel)
    {
        $this->noResponsavel = $noResponsavel;
    }

    /**
     * @return int
     */
    public function getNoEmail()
    {
        return $this->noEmail;
    }

    /**
     * @param int $noEmail
     */
    public function setNoEmail($noEmail)
    {
        $this->noEmail = $noEmail;
    }
}

