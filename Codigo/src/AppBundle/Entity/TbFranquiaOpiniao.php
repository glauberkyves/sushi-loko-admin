<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquiaOpiniao
 *
 * @ORM\Table(name="tb_franquia_opiniao", indexes={@ORM\Index(name="id_franquia", columns={"id_franquia"}), @ORM\Index(name="id_usuario", columns={"id_usuario"})})
 * @ORM\Entity
 */
class TbFranquiaOpiniao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franquia_opiniao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranquiaOpiniao;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_mensagem", type="text", length=65535, nullable=false)
     */
    private $dsMensagem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

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
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;


}

