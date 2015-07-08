<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueador
 *
 * @ORM\Table(name="tb_franqueador", indexes={@ORM\Index(name="fk_franqueador_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_franqueador_endereco_idx", columns={"id_endereco"}), @ORM\Index(name="fk_franqueador_configuracaofranquia_idx", columns={"id_configuracao_franquia"})})
 * @ORM\Entity
 */
class TbFranqueador
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
     * @ORM\ManyToOne(targetEntity="TbConfiguracaoFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_configuracao_franquia", referencedColumnName="idtb_configuracao_franquia")
     * })
     */
    private $idConfiguracaoFranquia;

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

