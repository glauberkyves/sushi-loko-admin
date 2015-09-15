<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbProduto
 *
 * @ORM\Table(name="tb_produto", indexes={@ORM\Index(name="id_cardapio", columns={"id_cardapio"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\ProdutoRepository")
 */
class TbProduto extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_produto", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduto;

    /**
     * @var string
     *
     * @ORM\Column(name="no_produto", type="string", length=100, nullable=false)
     */
    private $noProduto;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_valor", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $nuValor;

    /**
     * @var string
     *
     * @ORM\Column(name="no_imagem", type="string", length=100, nullable=false)
     */
    private $noImagem;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbCardapio
     *
     * @ORM\ManyToOne(targetEntity="TbCardapio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cardapio", referencedColumnName="id_cardapio")
     * })
     */
    private $idCardapio;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_produto", type="text", length=65535, nullable=true)
     */
    private $dsProduto;

    /**
     * @return int
     */
    public function getIdProduto()
    {
        return $this->idProduto;
    }

    /**
     * @param int $idProduto
     */
    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;
    }

    /**
     * @return string
     */
    public function getNoProduto()
    {
        return $this->noProduto;
    }

    /**
     * @param string $noProduto
     */
    public function setNoProduto($noProduto)
    {
        $this->noProduto = $noProduto;
    }

    /**
     * @return string
     */
    public function getNuValor()
    {
        return $this->nuValor;
    }

    /**
     * @param string $nuValor
     */
    public function setNuValor($nuValor)
    {
        $this->nuValor = $nuValor;
    }

    /**
     * @return string
     */
    public function getNoImagem()
    {
        return $this->noImagem;
    }

    /**
     * @param string $noImagem
     */
    public function setNoImagem($noImagem)
    {
        $this->noImagem = $noImagem;
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
     * @return string
     */
    public function getDsProduto()
    {
        return $this->dsProduto;
    }

    /**
     * @param string $dsProduto
     */
    public function setDsProduto($dsProduto)
    {
        $this->dsProduto = $dsProduto;
    }
}

