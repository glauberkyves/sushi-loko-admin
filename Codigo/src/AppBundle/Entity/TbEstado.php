<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEstado
 *
 * @ORM\Table(name="tb_estado")
 * @ORM\Entity
 */
class TbEstado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_estado", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEstado;

    /**
     * @var string
     *
     * @ORM\Column(name="sg_uf", type="string", length=10, nullable=false)
     */
    private $sgUf;

    /**
     * @var string
     *
     * @ORM\Column(name="no_estado", type="string", length=20, nullable=false)
     */
    private $noEstado;


}

