<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueador
 *
 * @ORM\Table(name="tb_franqueador", indexes={@ORM\Index(name="fk_franqueador_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_franqueador_endereco_idx", columns={"id_endereco"}), @ORM\Index(name="fk_franqueador_configuracaofranquia_idx", columns={"id_configuracao_franquia"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\FranqueadorRepository")
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
     * @var integer
     *
     * @ORM\Column(name="st_niveis", type="integer", nullable=false)
     */
    private $stNiveis;

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
     * @var string
     *
     * @ORM\Column(name="no_responsavel", type="string", length=255, nullable=false)
     */
    private $noResponsavel;

    /**
     * @var string
     *
     * @ORM\Column(name="no_email", type="string", length=255, nullable=false)
     */
    private $noEmail;

    /**
     * @var \TbConfiguracaoFranquia
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbConfiguracaoFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_configuracao_franquia", referencedColumnName="idtb_configuracao_franquia")
     * })
     */
    private $idConfiguracaoFranquia;

    /**
     * @var \TbEndereco
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbEndereco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_endereco", referencedColumnName="id_endereco")
     * })
     */
    private $idEndereco;

    /**
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;

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
     * @return string
     */
    public function getNoResponsavel()
    {
        return $this->noResponsavel;
    }

    /**
     * @param string $noResponsavel
     */
    public function setNoResponsavel($noResponsavel)
    {
        $this->noResponsavel = $noResponsavel;
    }

    /**
     * @return string
     */
    public function getNoEmail()
    {
        return $this->noEmail;
    }

    /**
     * @param string $noEmail
     */
    public function setNoEmail($noEmail)
    {
        $this->noEmail = $noEmail;
    }

    /**
     * @return \TbConfiguracaoFranquia
     */
    public function getIdConfiguracaoFranquia()
    {
        return $this->idConfiguracaoFranquia;
    }

    /**
     * @param \TbConfiguracaoFranquia $idConfiguracaoFranquia
     */
    public function setIdConfiguracaoFranquia($idConfiguracaoFranquia)
    {
        $this->idConfiguracaoFranquia = $idConfiguracaoFranquia;
    }

    /**
     * @return \TbEndereco
     */
    public function getIdEndereco()
    {
        return $this->idEndereco? $this->idEndereco: new TbEndereco();
    }

    /**
     * @param \TbEndereco $idEndereco
     */
    public function setIdEndereco($idEndereco)
    {
        $this->idEndereco = $idEndereco;
    }

    /**
     * @return \TbUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario? $this->idUsuario: new TbUsuario();
    }

    /**
     * @param \TbUsuario $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }
}

