<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTransacaoObservacao
 *
 * @ORM\Table(name="tb_transacao_observacao", indexes={@ORM\Index(name="fk_transacaoobservacao_usuario_idx", columns={"id_usuario"})})
 * @ORM\Entity
 */
class TbTransacaoObservacao
{
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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="TbTransacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_transacao_observacao", referencedColumnName="id_transacao")
     * })
     */
    private $idTransacaoObservacao;

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

