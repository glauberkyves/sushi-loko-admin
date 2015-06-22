<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbBairro
 *
 * @ORM\Table(name="tb_bairro")
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\BairroRepository")
 */
class TbBairro extends AbstractEntity
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
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbMunicipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_municipio", referencedColumnName="id_municipio")
     * })
     */
    private $idMunicipio;

    /**
     * @param int $idBairro
     */
    public function setIdBairro($idBairro)
    {
        $this->idBairro = $idBairro;
    }

    /**
     * @return int
     */
    public function getIdBairro()
    {
        return $this->idBairro;
    }

    /**
     * @param int $idMunicipio
     */
    public function setIdMunicipio(TbMunicipio $idMunicipio)
    {
        $this->idMunicipio = $idMunicipio;
    }

    /**
     * @return int
     */
    public function getIdMunicipio()
    {
        return $this->idMunicipio ? $this->idMunicipio : new TbMunicipio();
    }

    /**
     * @param string $noBairro
     */
    public function setNoBairro($noBairro)
    {
        $this->noBairro = $noBairro;
    }

    /**
     * @return string
     */
    public function getNoBairro()
    {
        return $this->noBairro;
    }
}