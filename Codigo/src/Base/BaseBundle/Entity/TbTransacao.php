<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTransacao
 *
 * @ORM\Table(name="tb_transacao", indexes={@ORM\Index(name="fk_transacao_franquia_idx", columns={"id_franquia"}), @ORM\Index(name="fk_transacao_operador_idx", columns={"id_operador"}), @ORM\Index(name="fk_transacao_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_transacao_tipotransacao_idx", columns={"id_tipo_transacao"}), @ORM\Index(name="fk_transacao_arquivo_idx", columns={"id_arquivo"}), @ORM\Index(name="fk_transacao_franqueador_idx", columns={"id_franqueador"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\TransacaoRepository")
 */
class TbTransacao extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_transacao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTransacao;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_valor", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $nuValor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \TbArquivo
     *
     * @ORM\ManyToOne(targetEntity="TbArquivo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arquivo", referencedColumnName="id_arquivo")
     * })
     */
    private $idArquivo;

    /**
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;

    /**
     * @var \TbFranquia
     *
     * @ORM\ManyToOne(targetEntity="TbFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franquia", referencedColumnName="id_franquia")
     * })
     */
    private $idFranquia;

    /**
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_operador", referencedColumnName="id_usuario")
     * })
     */
    private $idOperador;

    /**
     * @var \TbTipoTransacao
     *
     * @ORM\ManyToOne(targetEntity="TbTipoTransacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_transacao", referencedColumnName="id_tipo_transacao")
     * })
     */
    private $idTipoTransacao;

    /**
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;

    /**
     * @return int
     */
    public function getIdTransacao()
    {
        return $this->idTransacao;
    }

    /**
     * @param int $idTransacao
     */
    public function setIdTransacao($idTransacao)
    {
        $this->idTransacao = $idTransacao;
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
     * @return \TbFranquia
     */
    public function getIdFranquia()
    {
        return $this->idFranquia;
    }

    /**
     * @param \TbFranquia $idFranquia
     */
    public function setIdFranquia($idFranquia)
    {
        $this->idFranquia = $idFranquia;
    }

    /**
     * @return \TbUsuario
     */
    public function getIdOperador()
    {
        return $this->idOperador;
    }

    /**
     * @param \TbUsuario $idOperador
     */
    public function setIdOperador($idOperador)
    {
        $this->idOperador = $idOperador;
    }

    /**
     * @return \TbTipoTransacao
     */
    public function getIdTipoTransacao()
    {
        return $this->idTipoTransacao;
    }

    /**
     * @param \TbTipoTransacao $idTipoTransacao
     */
    public function setIdTipoTransacao($idTipoTransacao)
    {
        $this->idTipoTransacao = $idTipoTransacao;
    }

    /**
     * @return \TbUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
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
    public function getNuValor()
    {
        return $this->nuValor;
    }

    /**
     * @param string $nuValor
     */
    public function setNuValor($nuValor)
    {
        $this->nuValor = $nuValor;
    }

    /**
     * @return \TbArquivo
     */
    public function getIdArquivo()
    {
        return $this->idArquivo;
    }

    /**
     * @param \TbArquivo $idArquivo
     */
    public function setIdArquivo($idArquivo)
    {
        $this->idArquivo = $idArquivo;
    }

    /**
     * @return \TbFranqueador
     */
    public function getIdFranqueador()
    {
        return $this->idFranqueador;
    }

    /**
     * @param \TbFranqueador $idFranqueador
     */
    public function setIdFranqueador($idFranqueador)
    {
        $this->idFranqueador = $idFranqueador;
    }


}

