<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbMunicipio
 *
 * @ORM\Table(name="tb_municipio", indexes={@ORM\Index(name="FK_MUNICIPIO_ESTADO_idx", columns={"id_estado"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\MunicipioRepository")
 */
class TbMunicipio extends AbstractEntity
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
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbEstado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estado", referencedColumnName="id_estado")
     * })
     */
    private $idEstado;

    /**
     * @param \TbEstado $idEstado
     */
    public function setIdEstado($idEstado)
    {
        $this->idEstado = $idEstado;
    }

    /**
     * @return \TbEstado
     */
    public function getIdEstado()
    {
        return $this->idEstado ? $this->idEstado : new TbEstado();
    }

    /**
     * @return int
     */
    public function getIdMunicipio()
    {
        return $this->idMunicipio;
    }

    /**
     * @param string $noMunicipio
     */
    public function setNoMunicipio($noMunicipio)
    {
        $this->noMunicipio = $noMunicipio;
    }

    /**
     * @return string
     */
    public function getNoMunicipio()
    {
        return $this->noMunicipio;
    }
}
