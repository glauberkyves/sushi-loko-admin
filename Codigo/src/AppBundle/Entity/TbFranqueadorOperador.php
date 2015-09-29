<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueadorOperador
 *
 * @ORM\Table(name="tb_franqueador_operador", indexes={@ORM\Index(name="fk_franqueadoroperador_franqueador_idx", columns={"id_franqueador"}), @ORM\Index(name="fk_franqueadoroperador_operador_idx", columns={"id_operador"})})
 * @ORM\Entity
 */
class TbFranqueadorOperador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franqueador_operador", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranqueadorOperador;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_visualizacao", type="integer", nullable=false)
     */
    private $stVisualizacao = '1';

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
     *   @ORM\JoinColumn(name="id_operador", referencedColumnName="id_usuario")
     * })
     */
    private $idOperador;


}

