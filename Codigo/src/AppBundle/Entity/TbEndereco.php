<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEndereco
 *
 * @ORM\Table(name="tb_endereco", indexes={@ORM\Index(name="FK_ENDERECO_MUNICPIO_idx", columns={"id_bairro"}), @ORM\Index(name="FK_ENDERECO_MUNICIPIO_idx", columns={"id_municipio"})})
 * @ORM\Entity
 */
class TbEndereco
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_endereco", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEndereco;

    /**
     * @var string
     *
     * @ORM\Column(name="no_logradouro", type="string", length=100, nullable=false)
     */
    private $noLogradouro;

    /**
     * @var string
     *
     * @ORM\Column(name="no_complemento", type="string", length=100, nullable=true)
     */
    private $noComplemento;

    /**
     * @var string
     *
     * @ORM\Column(name="no_endereco_amigavel", type="string", length=150, nullable=true)
     */
    private $noEnderecoAmigavel;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_endereco", type="string", length=10, nullable=true)
     */
    private $nuEndereco;

    /**
     * @var string
     *
     * @ORM\Column(name="no_bairro", type="string", length=200, nullable=true)
     */
    private $noBairro;

    /**
     * @var int
     *
     * @ORM\Column(name="nu_cep", type="integer", nullable=true)
     */
    private $nuCep;

    /**
     * @var string
     *
     * @ORM\Column(name="no_longitude", type="string", length=250, nullable=true)
     */
    private $noLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="no_latitude", type="string", length=250, nullable=true)
     */
    private $noLatitude;

    /**
     * @var \TbBairro
     *
     * @ORM\ManyToOne(targetEntity="TbBairro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bairro", referencedColumnName="id_bairro")
     * })
     */
    private $idBairro;

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

