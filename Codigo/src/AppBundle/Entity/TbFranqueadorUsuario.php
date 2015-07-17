<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueadorUsuario
 *
 * @ORM\Table(name="tb_franqueador_usuario", indexes={@ORM\Index(name="id_franqueador", columns={"id_franqueador"}), @ORM\Index(name="id_usuario", columns={"id_usuario"})})
 * @ORM\Entity
 */
class TbFranqueadorUsuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franqueador_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranqueadorUsuario;

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

