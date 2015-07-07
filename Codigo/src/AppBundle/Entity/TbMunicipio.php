<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbMunicipio
 *
 * @ORM\Table(name="tb_municipio", indexes={@ORM\Index(name="FK_MUNICIPIO_ESTADO_idx", columns={"id_estado"})})
 * @ORM\Entity
 */
class TbMunicipio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_municipio", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMunicipio;

    /**
     * @var string
     *
     * @ORM\Column(name="no_municipio", type="string", length=100, nullable=false)
     */
    private $noMunicipio;

    /**
     * @var \TbEstado
     *
     * @ORM\ManyToOne(targetEntity="TbEstado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estado", referencedColumnName="id_estado")
     * })
     */
    private $idEstado;


}

