<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbRequisacaoTransacao
 *
 * @ORM\Table(name="tb_requisacao_transacao", indexes={@ORM\Index(name="fk_requisicaotransacao_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_requisicaotransacao_franqueador_idx", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbRequisacaoTransacao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_requisacao_transacao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRequisacaoTransacao;

    /**
     * @var string
     *
     * @ORM\Column(name="no_senha", type="string", length=100, nullable=false)
     */
    private $noSenha;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_valor", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $nuValor;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_utilizado", type="integer", nullable=false)
     */
    private $stUtilizado;

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
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;

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

