<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTransacao
 *
 * @ORM\Table(name="tb_transacao", indexes={@ORM\Index(name="fk_transacao_franquia_idx", columns={"id_franquia"}), @ORM\Index(name="fk_transacao_operador_idx", columns={"id_operador"}), @ORM\Index(name="fk_transacao_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_transacao_tipotransacao_idx", columns={"id_tipo_transacao"}), @ORM\Index(name="fk_transacao_arquivo_idx", columns={"id_arquivo"}), @ORM\Index(name="fk_transacao_franqueador_idx", columns={"id_franqueador"}), @ORM\Index(name="id_requisacao_transacao", columns={"id_requisacao_transacao"})})
 * @ORM\Entity
 */
class TbTransacao
{
    /**
     * @var int
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
     * @var int
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
     * @var \TbRequisacaoTransacao
     *
     * @ORM\ManyToOne(targetEntity="TbRequisacaoTransacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_requisacao_transacao", referencedColumnName="id_requisacao_transacao")
     * })
     */
    private $idRequisacaoTransacao;


}

