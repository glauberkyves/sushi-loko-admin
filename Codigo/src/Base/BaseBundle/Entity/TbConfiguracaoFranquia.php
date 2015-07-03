<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbConfiguracaoFranquia
 *
 * @ORM\Table(name="tb_configuracao_franquia")
 * @ORM\Entity
 */
class TbConfiguracaoFranquia extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idtb_configuracao_franquia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtbConfiguracaoFranquia;

    /**
     * @return int
     */
    public function getIdtbConfiguracaoFranquia()
    {
        return $this->idtbConfiguracaoFranquia;
    }

    /**
     * @param int $idtbConfiguracaoFranquia
     */
    public function setIdtbConfiguracaoFranquia($idtbConfiguracaoFranquia)
    {
        $this->idtbConfiguracaoFranquia = $idtbConfiguracaoFranquia;
    }
}

