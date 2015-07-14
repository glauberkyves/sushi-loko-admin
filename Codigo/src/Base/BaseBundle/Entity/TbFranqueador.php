<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueador
 *
 * @ORM\Table(name="tb_franqueador", indexes={@ORM\Index(name="fk_franqueador_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_franqueador_endereco_idx", columns={"id_endereco"}), @ORM\Index(name="fk_franqueador_operador_idx", columns={"id_operador"})})
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
     * @var string
     *
     * @ORM\Column(name="nu_cnpj", type="string", length=14, nullable=false)
     */
    private $nuCnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="no_razao_social", type="string", length=100, nullable=false)
     */
    private $noRazaoSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="no_fantasia", type="string", length=100, nullable=false)
     */
    private $noFantasia;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_niveis", type="integer", nullable=false)
     */
    private $stNiveis;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_valor_minimo_resgate", type="integer", nullable=false)
     */
    private $nuValorMinimoResgate;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_pontos_transacao", type="integer", nullable=false)
     */
    private $nuPontosTransacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_porcentagem_bonus_transacao", type="integer", nullable=false)
     */
    private $nuPorcentagemBonusTransacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_validade_bonus", type="datetime", nullable=false)
     */
    private $dtValidadeBonus;

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
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_operador", referencedColumnName="id_usuario")
     * })
     */
    private $idOperador;

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
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario",unique=true)
     * })
     */
    private $idUsuario;

    /**
     * @var TbPessoaJuridica
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbConfiguracaoFranquiaNivel", mappedBy="idFranqueador")
     */
    protected $idConfiguracaoFranquiaNivel;


    public function __construct()
    {
        $this->dtValidadeBonus = new \DateTime();
    }

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
     * @return \TbEndereco
     */
    public function getIdEndereco()
    {
        return $this->idEndereco ? $this->idEndereco : new TbEndereco();
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
        return $this->idUsuario ? $this->idUsuario : new TbUsuario();
    }

    /**
     * @param \TbUsuario $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return string
     */
    public function getNuCnpj()
    {
        return $this->nuCnpj;
    }

    /**
     * @param string $nuCnpj
     */
    public function setNuCnpj($nuCnpj)
    {
        $this->nuCnpj = $nuCnpj;
    }

    /**
     * @return string
     */
    public function getNoRazaoSocial()
    {
        return $this->noRazaoSocial;
    }

    /**
     * @param string $noRazaoSocial
     */
    public function setNoRazaoSocial($noRazaoSocial)
    {
        $this->noRazaoSocial = $noRazaoSocial;
    }

    /**
     * @return string
     */
    public function getNoFantasia()
    {
        return $this->noFantasia;
    }

    /**
     * @param string $noFantasia
     */
    public function setNoFantasia($noFantasia)
    {
        $this->noFantasia = $noFantasia;
    }

    /**
     * @return int
     */
    public function getNuValorMinimoResgate()
    {
        return $this->nuValorMinimoResgate;
    }

    /**
     * @param int $nuValorMinimoResgate
     */
    public function setNuValorMinimoResgate($nuValorMinimoResgate)
    {
        $this->nuValorMinimoResgate = $nuValorMinimoResgate;
    }

    /**
     * @return int
     */
    public function getNuPontosTransacao()
    {
        return $this->nuPontosTransacao;
    }

    /**
     * @param int $nuPontosTransacao
     */
    public function setNuPontosTransacao($nuPontosTransacao)
    {
        $this->nuPontosTransacao = $nuPontosTransacao;
    }

    /**
     * @return int
     */
    public function getNuPorcentagemBonusTransacao()
    {
        return $this->nuPorcentagemBonusTransacao;
    }

    /**
     * @param int $nuPorcentagemBonusTransacao
     */
    public function setNuPorcentagemBonusTransacao($nuPorcentagemBonusTransacao)
    {
        $this->nuPorcentagemBonusTransacao = $nuPorcentagemBonusTransacao;
    }

    /**
     * @return \DateTime
     */
    public function getDtValidadeBonus()
    {
        return $this->dtValidadeBonus;
    }

    /**
     * @param \DateTime $dtValidadeBonus
     */
    public function setDtValidadeBonus($dtValidadeBonus)
    {
        $this->dtValidadeBonus = $dtValidadeBonus;
    }

    /**
     * @return TbPessoaJuridica
     */
    public function getIdConfiguracaoFranquiaNivel()
    {
        return $this->idConfiguracaoFranquiaNivel;
    }

    /**
     * @param TbPessoaJuridica $idConfiguracaoFranquiaNivel
     */
    public function setIdConfiguracaoFranquiaNivel($idConfiguracaoFranquiaNivel)
    {
        $this->idConfiguracaoFranquiaNivel = $idConfiguracaoFranquiaNivel;
    }

    /**
     * @return \TbUsuario
     */
    public function getIdOperador()
    {
        return $this->idOperador ? $this->idOperador : new TbUsuario();
    }

    /**
     * @param \TbUsuario $idOperador
     */
    public function setIdOperador($idOperador)
    {
        $this->idOperador = $idOperador;
    }
}