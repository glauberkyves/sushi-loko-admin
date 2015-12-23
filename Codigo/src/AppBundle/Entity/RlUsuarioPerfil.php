<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RlUsuarioPerfil
 *
 * @ORM\Table(name="rl_usuario_perfil", indexes={@ORM\Index(name="fk_usuarioperfil_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_usuarioperfil_perfil_idx", columns={"id_perfil"})})
 * @ORM\Entity
 */
class RlUsuarioPerfil
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_usuario_perfil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsuarioPerfil;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbPerfil
     *
     * @ORM\ManyToOne(targetEntity="TbPerfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     * })
     */
    private $idPerfil;

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

