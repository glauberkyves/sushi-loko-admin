<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquia
 *
 * @ORM\Table(name="tb_franquia", indexes={@ORM\Index(name="fk_franquia_franqueador_idx", columns={"id_franqueador"}), @ORM\Index(name="fk_franquia_endereco_idx", columns={"id_endereco"}), @ORM\Index(name="fk_franquia_cardapio_idx", columns={"id_cardapio"})})
 * @ORM\Entity
 */
class TbFranquia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franquia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranquia;

    /**
     * @var string
     *
     * @ORM\Column(name="no_franquia", type="string", length=100, nullable=true)
     */
    private $noFranquia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=true)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=true)
     */
    private $stAtivo;

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
     * @var \TbEndereco
     *
     * @ORM\ManyToOne(targetEntity="TbEndereco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_endereco", referencedColumnName="id_endereco")
     * })
     */
    private $idEndereco;

    /**
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;


}

