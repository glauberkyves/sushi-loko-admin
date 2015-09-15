<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueadorComentarioUsuario
 *
 * @ORM\Table(name="tb_franqueador_comentario_usuario", indexes={@ORM\Index(name="fk_franqueadorcomentariousuario_franqueadousuario_idx", columns={"id_franqueador_usuario"})})
 * @ORM\Entity
 */
class TbFranqueadorComentarioUsuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_franqueador_comentario_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranqueadorComentarioUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_comentario", type="text", length=65535, nullable=false)
     */
    private $dsComentario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

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

