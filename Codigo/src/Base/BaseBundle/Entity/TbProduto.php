<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbProduto
 *
 * @ORM\Table(name="tb_produto")
 * @ORM\Entity
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


}

