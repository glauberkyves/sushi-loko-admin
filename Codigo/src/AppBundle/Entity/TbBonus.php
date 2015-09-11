<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbBonus
 *
 * @ORM\Table(name="tb_bonus", indexes={@ORM\Index(name="fk_bonus_franqueadorusuario_idx", columns={"id_franqueador_usuario"})})
 * @ORM\Entity
 */
class TbBonus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_bonus", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_bonus", type="integer", nullable=false)
     */
    private $nuBonus;

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
     * @var \TbFranqueadorUsuario
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueadorUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador_usuario", referencedColumnName="id_franqueador_usuario")
     * })
     */
    private $idFranqueadorUsuario;


}

