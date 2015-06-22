<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEstado
 *
 * @ORM\Table(name="tb_estado")
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\EstadoRepository")
 */
class TbEstado extends AbstractEntity
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
     * @ORM\Column(name="no_estado", type="string", length=20, nullable=false)
     */
    private $noEstado = '';

    /**
     * @var string
     *
     * @ORM\Column(name="sg_uf", type="string", length=10, nullable=false)
     */
    private $sgUf = '';

    /**
     * @return int
     */
    public function getIdEstado()
    {
        return $this->idEstado;
    }

    /**
     * @param string $noEstado
     */
    public function setNoEstado($noEstado)
    {
        $this->noEstado = $noEstado;
    }

    /**
     * @return string
     */
    public function getNoEstado()
    {
        return $this->noEstado;
    }

    /**
     * @param string $sgUf
     */
    public function setSgUf($sgUf)
    {
        $this->sgUf = $sgUf;
    }

    /**
     * @return string
     */
    public function getSgUf()
    {
        return $this->sgUf;
    }
}
