<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquiaCardapio
 *
 * @ORM\Table(name="tb_franquia_cardapio", indexes={@ORM\Index(name="fk_franquiacardapio_franquia_idx", columns={"id_franquia"}), @ORM\Index(name="fk_franquiacardapio_cardapio_idx", columns={"id_cardapio"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\FranquiaCardapioRepository")
 */
class TbFranquiaCardapio extends AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_franquia_cardapio", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranquiaCardapio;

    /**
     * @var \TbCardapio
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbCardapio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cardapio", referencedColumnName="id_cardapio")
     * })
     */
    private $idCardapio;

    /**
     * @var \TbFranquia
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franquia", referencedColumnName="id_franquia")
     * })
     */
    private $idFranquia;

    /**
     * @return int
     */
    public function getIdFranquiaCardapio()
    {
        return $this->idFranquiaCardapio;
    }

    /**
     * @param int $idFranquiaCardapio
     */
    public function setIdFranquiaCardapio($idFranquiaCardapio)
    {
        $this->idFranquiaCardapio = $idFranquiaCardapio;
    }

    /**
     * @return \TbCardapio
     */
    public function getIdCardapio()
    {
        return $this->idCardapio;
    }

    /**
     * @param \TbCardapio $idCardapio
     */
    public function setIdCardapio($idCardapio)
    {
        $this->idCardapio = $idCardapio;
    }

    /**
     * @return \TbFranquia
     */
    public function getIdFranquia()
    {
        return $this->idFranquia;
    }

    /**
     * @param \TbFranquia $idFranquia
     */
    public function setIdFranquia($idFranquia)
    {
        $this->idFranquia = $idFranquia;
    }
}