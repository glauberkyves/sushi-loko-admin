<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbCardapio
 *
 * @ORM\Table(name="tb_cardapio")
 * @ORM\Entity
 */
class TbCardapio
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


}

