<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbConfiguracaoFtp
 *
 * @ORM\Table(name="tb_configuracao_ftp", indexes={@ORM\Index(name="fk_configuracaoftp_franqueador_idx", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbConfiguracaoFtp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_configuracao_ftp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idConfiguracaoFtp;

    /**
     * @var string
     *
     * @ORM\Column(name="no_host", type="string", length=100, nullable=false)
     */
    private $noHost;

    /**
     * @var string
     *
     * @ORM\Column(name="no_usuario", type="string", length=100, nullable=false)
     */
    private $noUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="no_senha", type="string", length=100, nullable=false)
     */
    private $noSenha;

    /**
     * @var string
     *
     * @ORM\Column(name="no_pasta", type="string", length=500, nullable=false)
     */
    private $noPasta;

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
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;


}

