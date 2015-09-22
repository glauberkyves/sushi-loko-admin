<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbCardapio
 *
 * @ORM\Table(name="tb_cardapio", indexes={@ORM\Index(name="id_franqueador", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbCardapio
{
    /**
     * @var int
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
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;


}

