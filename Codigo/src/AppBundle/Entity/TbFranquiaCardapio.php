<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquiaCardapio
 *
 * @ORM\Table(name="tb_franquia_cardapio", indexes={@ORM\Index(name="fk_franquiacardapio_franquia_idx", columns={"id_franquia"}), @ORM\Index(name="fk_franquiacardapio_cardapio_idx", columns={"id_cardapio"})})
 * @ORM\Entity
 */
class TbFranquiaCardapio
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
     * @ORM\ManyToOne(targetEntity="TbCardapio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cardapio", referencedColumnName="id_cardapio")
     * })
     */
    private $idCardapio;

    /**
     * @var \TbFranquia
     *
     * @ORM\ManyToOne(targetEntity="TbFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franquia", referencedColumnName="id_franquia")
     * })
     */
    private $idFranquia;


}

