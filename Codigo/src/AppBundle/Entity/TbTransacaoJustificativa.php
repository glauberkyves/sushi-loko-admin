<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTransacaoJustificativa
 *
 * @ORM\Table(name="tb_transacao_justificativa", indexes={@ORM\Index(name="fk_transacaoobservacao_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_transacaojustificativa_transacao_idx", columns={"id_transacao"})})
 * @ORM\Entity
 */
class TbTransacaoJustificativa
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_transacao_justificativa", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTransacaoJustificativa;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_justificativa", type="text", length=65535, nullable=false)
     */
    private $dsJustificativa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbTransacao
     *
     * @ORM\ManyToOne(targetEntity="TbTransacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_transacao", referencedColumnName="id_transacao")
     * })
     */
    private $idTransacao;

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

