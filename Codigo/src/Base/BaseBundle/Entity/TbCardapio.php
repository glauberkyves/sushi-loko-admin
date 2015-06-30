<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbCardapio
 *
 * @ORM\Table(name="tb_cardapio")
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\CardapioRepository")
 */
class TbCardapio extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cardapio", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCardapio;

    /**
     * @var string
     *
     * @ORM\Column(name="no_cardapio", type="string", length=100, nullable=false)
     */
    private $noCardapio;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbProduto", mappedBy="idCardapio")
     */
    private $idProduto;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idProduto = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdCardapio()
    {
        return $this->idCardapio;
    }

    /**
     * @param int $idCardapio
     */
    public function setIdCardapio($idCardapio)
    {
        $this->idCardapio = $idCardapio;
    }

    /**
     * @return string
     */
    public function getNoCardapio()
    {
        return $this->noCardapio;
    }

    /**
     * @param string $noCardapio
     */
    public function setNoCardapio($noCardapio)
    {
        $this->noCardapio = $noCardapio;
    }

    /**
     * @return int
     */
    public function getStAtivo()
    {
        return $this->stAtivo;
    }

    /**
     * @param int $stAtivo
     */
    public function setStAtivo($stAtivo)
    {
        $this->stAtivo = $stAtivo;
    }

    /**
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * @param \DateTime $dtCadastro
     */
    public function setDtCadastro($dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdProduto()
    {
        return $this->idProduto;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idProduto
     */
    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;
    }


}

