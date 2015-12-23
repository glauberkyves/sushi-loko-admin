<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueador
 *
 * @ORM\Table(name="tb_franqueador", indexes={@ORM\Index(name="fk_franqueador_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_franqueador_endereco_idx", columns={"id_endereco"})})
 * @ORM\Entity
 */
class TbFranqueador
{
    /**
     * @var int
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
     * @var int
     *
     * @ORM\Column(name="st_niveis", type="integer", nullable=false)
     */
    private $stNiveis;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_valor_minimo_resgate", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $nuValorMinimoResgate;

    /**
     * @var int
     *
     * @ORM\Column(name="nu_pontos_transacao", type="integer", nullable=false)
     */
    private $nuPontosTransacao;

    /**
     * @var int
     *
     * @ORM\Column(name="nu_porcentagem_bonus_transacao", type="integer", nullable=false)
     */
    private $nuPorcentagemBonusTransacao;

    /**
     * @var int
     *
     * @ORM\Column(name="nu_pontos_bonus_cadastro", type="integer", nullable=true)
     */
    private $nuPontosBonusCadastro;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_valor_bonus_cadastro", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $nuValorBonusCadastro;

    /**
     * @var int
     *
     * @ORM\Column(name="nu_validade_bonus", type="integer", nullable=false)
     */
    private $nuValidadeBonus;

    /**
     * @var string
     *
     * @ORM\Column(name="no_url_compra_online", type="string", length=100, nullable=true)
     */
    private $noUrlCompraOnline;

    /**
     * @var int
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_inicio_cadastro", type="datetime", nullable=true)
     */
    private $dtInicioCadastro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbEndereco
     *
     * @ORM\ManyToOne(targetEntity="TbEndereco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_endereco", referencedColumnName="id_endereco")
     * })
     */
    private $idEndereco;

    /**
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;


}

