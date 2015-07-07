<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbBairro
 *
 * @ORM\Table(name="tb_bairro", indexes={@ORM\Index(name="FK_BAIRRO_MUNICIPIO_idx", columns={"id_municipio"})})
 * @ORM\Entity
 */
class TbBairro
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_bairro", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBairro;

    /**
     * @var string
     *
     * @ORM\Column(name="no_bairro", type="string", length=200, nullable=false)
     */
    private $noBairro;

    /**
     * @var \TbMunicipio
     *
     * @ORM\ManyToOne(targetEntity="TbMunicipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_municipio", referencedColumnName="id_municipio")
     * })
     */
    private $idMunicipio;


}

