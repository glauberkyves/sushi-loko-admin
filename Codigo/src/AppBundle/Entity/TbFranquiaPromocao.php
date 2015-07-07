<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquiaPromocao
 *
 * @ORM\Table(name="tb_franquia_promocao", indexes={@ORM\Index(name="fk_franquiapromocao_franquia_idx", columns={"id_franquia"}), @ORM\Index(name="fk_franquiapromocao_promocao_idx", columns={"id_promocao"})})
 * @ORM\Entity
 */
class TbFranquiaPromocao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franquia_promocao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranquiaPromocao;

    /**
     * @var \TbFranquia
     *
     * @ORM\ManyToOne(targetEntity="TbFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franquia", referencedColumnName="id_franquia")
     * })
     */
    private $idFranquia;

    /**
     * @var \TbPromocao
     *
     * @ORM\ManyToOne(targetEntity="TbPromocao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_promocao", referencedColumnName="id_promocao")
     * })
     */
    private $idPromocao;


}

