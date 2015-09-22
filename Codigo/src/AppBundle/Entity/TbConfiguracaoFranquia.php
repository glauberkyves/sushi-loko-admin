<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbConfiguracaoFranquia
 *
 * @ORM\Table(name="tb_configuracao_franquia")
 * @ORM\Entity
 */
class TbConfiguracaoFranquia
{
    /**
     * @var int
     *
     * @ORM\Column(name="idtb_configuracao_franquia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtbConfiguracaoFranquia;


}

