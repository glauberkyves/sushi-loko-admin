<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbProduto
 *
 * @ORM\Table(name="tb_produto", indexes={@ORM\Index(name="id_cardapio", columns={"id_cardapio"})})
 * @ORM\Entity
 */
class TbProduto
{
    /**
     * @var int
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
     * @ORM\Column(name="nu_valor", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $nuValor;

    /**
     * @var string
     *
     * @ORM\Column(name="no_imagem", type="string", length=100, nullable=false)
     */
    private $noImagem;

    /**
     * @var int
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
     * @var \TbCardapio
     *
     * @ORM\ManyToOne(targetEntity="TbCardapio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cardapio", referencedColumnName="id_cardapio")
     * })
     */
    private $idCardapio;


}

