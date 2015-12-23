<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquia
 *
 * @ORM\Table(name="tb_franquia", indexes={@ORM\Index(name="fk_franquia_franqueador_idx", columns={"id_franqueador"}), @ORM\Index(name="fk_franquia_endereco_idx", columns={"id_endereco"}), @ORM\Index(name="fk_franquia_cardapio_idx", columns={"id_cardapio"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\FranquiaRepository")
 */
class TbFranquia extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franquia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranquia;

    /**
     * @var string
     *
     * @ORM\Column(name="no_franquia", type="string", length=100, nullable=true)
     */
    private $noFranquia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=true)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=true)
     */
    private $stAtivo;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_codigo_loja", type="integer", nullable=false)
     */
    private $nuCodigoLoja;

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
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbFranquiaPromocao", mappedBy="idFranquia")
     */
    private $idFranquiaPromocao;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbFranquiaCardapio", mappedBy="idFranquia")
     */
    private $idFranquiaCardapio;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbFranquiaOperador", mappedBy="idFranquia")
     */
    private $idFranquiaOperador;

    /**
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario", unique=true)
     * })
     */
    private $idUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idFranquiaPromocao = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idFranquiaCardapio = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idFranquiaOperador = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdFranquia()
    {
        return $this->idFranquia;
    }

    /**
     * @param int $idFranquia
     */
    public function setIdFranquia($idFranquia)
    {
        $this->idFranquia = $idFranquia;
    }

    /**
     * @return string
     */
    public function getNoFranquia()
    {
        return $this->noFranquia;
    }

    /**
     * @param string $noFranquia
     */
    public function setNoFranquia($noFranquia)
    {
        $this->noFranquia = $noFranquia;
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
     * @return \TbEndereco
     */
    public function getIdEndereco()
    {
        return $this->idEndereco ?: new \Base\BaseBundle\Entity\TbEndereco;
    }

    /**
     * @param \TbEndereco $idEndereco
     */
    public function setIdEndereco($idEndereco)
    {
        $this->idEndereco = $idEndereco;
    }

    /**
     * @return \TbFranqueador
     */
    public function getIdFranqueador()
    {
        return $this->idFranqueador ?: new \Base\BaseBundle\Entity\TbFranqueador;
    }

    /**
     * @param \TbFranqueador $idFranqueador
     */
    public function setIdFranqueador($idFranqueador)
    {
        $this->idFranqueador = $idFranqueador;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdFranquiaPromocao()
    {
        return $this->idFranquiaPromocao;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idFranquiaPromocao
     */
    public function setIdFranquiaPromocao($idFranquiaPromocao)
    {
        $this->idFranquiaPromocao = $idFranquiaPromocao;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdFranquiaOperador()
    {
        return $this->idFranquiaOperador;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idFranquiaOperador
     */
    public function setIdFranquiaOperador($idFranquiaOperador)
    {
        $this->idFranquiaOperador = $idFranquiaOperador;
    }

    /**
     * @return \TbUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario ?: new \Base\BaseBundle\Entity\TbUsuario;
    }

    /**
     * @param \TbUsuario $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return int
     */
    public function getNuCodigoLoja()
    {
        return $this->nuCodigoLoja;
    }

    /**
     * @param int $nuCodigoLoja
     */
    public function setNuCodigoLoja($nuCodigoLoja)
    {
        $this->nuCodigoLoja = $nuCodigoLoja;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdFranquiaCardapio()
    {
        return $this->idFranquiaCardapio;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idFranquiaCardapio
     */
    public function setIdFranquiaCardapio($idFranquiaCardapio)
    {
        $this->idFranquiaCardapio = $idFranquiaCardapio;
    }
}