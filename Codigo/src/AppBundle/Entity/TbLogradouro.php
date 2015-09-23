<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbLogradouro
 *
 * @ORM\Table(name="tb_logradouro", indexes={@ORM\Index(name="FK_LOGRADOURO_BAIRRO_idx", columns={"id_bairro"})})
 * @ORM\Entity
 */
class TbLogradouro
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_logradouro", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLogradouro;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_logradouro", type="integer", nullable=true)
     */
    private $idTipoLogradouro;

    /**
     * @var string
     *
     * @ORM\Column(name="no_logradouro", type="string", length=200, nullable=true)
     */
    private $noLogradouro;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_cep", type="integer", nullable=false)
     */
    private $nuCep;

    /**
     * @var \TbBairro
     *
     * @ORM\ManyToOne(targetEntity="TbBairro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bairro", referencedColumnName="id_bairro")
     * })
     */
    private $idBairro;


}

