<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEndereco
 *
 * @ORM\Table(name="tb_endereco", indexes={@ORM\Index(name="FK_ENDERECO_MUNICPIO_idx", columns={"id_bairro"}), @ORM\Index(name="FK_ENDERECO_MUNICIPIO_idx", columns={"id_municipio"})})
 * @ORM\Entity
 */
class TbEndereco extends AbstractEntity
{
    /**
     * @var integer
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
     * @ORM\Column(name="no_endereco_amigavel", type="string", length=100, nullable=true)
     */
    private $noEnderecoAmigavel;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_endereco", type="string", length=10, nullable=true)
     */
    private $nuEndereco;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_cep", type="string", length=8, nullable=true)
     */
    private $nuCep;

    /**
     * @var string
     *
     * @ORM\Column(name="no_longitude", type="string", length=250, nullable=false)
     */
    private $noLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="no_latitude", type="string", length=250, nullable=false)
     */
    private $noLatitude;

    /**
     * @var \TbBairro
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbBairro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bairro", referencedColumnName="id_bairro")
     * })
     */
    private $idBairro;

    /**
     * @var \TbMunicipio
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbMunicipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_municipio", referencedColumnName="id_municipio")
     * })
     */
    private $idMunicipio;

    /**
     * @return int
     */
    public function getIdEndereco()
    {
        return $this->idEndereco;
    }

    /**
     * @param int $idEndereco
     */
    public function setIdEndereco($idEndereco)
    {
        $this->idEndereco = $idEndereco;
    }

    /**
     * @return string
     */
    public function getNoLogradouro()
    {
        return $this->noLogradouro;
    }

    /**
     * @param string $noLogradouro
     */
    public function setNoLogradouro($noLogradouro)
    {
        $this->noLogradouro = $noLogradouro;
    }

    /**
     * @return string
     */
    public function getNoComplemento()
    {
        return $this->noComplemento;
    }

    /**
     * @param string $noComplemento
     */
    public function setNoComplemento($noComplemento)
    {
        $this->noComplemento = $noComplemento;
    }

    /**
     * @return string
     */
    public function getNuEndereco()
    {
        return $this->nuEndereco;
    }

    /**
     * @param string $nuEndereco
     */
    public function setNuEndereco($nuEndereco)
    {
        $this->nuEndereco = $nuEndereco;
    }

    /**
     * @return int
     */
    public function getNuCep()
    {
        return $this->nuCep;
    }

    /**
     * @param int $nuCep
     */
    public function setNuCep($nuCep)
    {
        $this->nuCep = $nuCep;
    }

    /**
     * @return string
     */
    public function getNoLongitude()
    {
        return $this->noLongitude;
    }

    /**
     * @param string $noLongitude
     */
    public function setNoLongitude($noLongitude)
    {
        $this->noLongitude = $noLongitude;
    }

    /**
     * @return string
     */
    public function getNoLatitude()
    {
        return $this->noLatitude;
    }

    /**
     * @param string $noLatitude
     */
    public function setNoLatitude($noLatitude)
    {
        $this->noLatitude = $noLatitude;
    }

    /**
     * @return \TbBairro
     */
    public function getIdBairro()
    {
        return $this->idBairro ? $this->idBairro : new TbBairro();
    }

    /**
     * @param \TbBairro $idBairro
     */
    public function setIdBairro($idBairro)
    {
        $this->idBairro = $idBairro;
    }

    /**
     * @return \TbMunicipio
     */
    public function getIdMunicipio()
    {
        return $this->idMunicipio ? $this->idMunicipio : new TbMunicipio();
    }

    /**
     * @param \TbMunicipio $idMunicipio
     */
    public function setIdMunicipio($idMunicipio)
    {
        $this->idMunicipio = $idMunicipio;
    }

    /**
     * @return string
     */
    public function getNoEnderecoAmigavel()
    {
        return $this->noEnderecoAmigavel;
    }

    /**
     * @param string $noEnderecoAmigavel
     */
    public function setNoEnderecoAmigavel($noEnderecoAmigavel)
    {
        $this->noEnderecoAmigavel = $noEnderecoAmigavel;
    }
}

