<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTipoTransacao
 *
 * @ORM\Table(name="tb_tipo_transacao")
 * @ORM\Entity
 */
class TbTipoTransacao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_transacao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTipoTransacao;

    /**
     * @var string
     *
     * @ORM\Column(name="no_tipo_transacao", type="string", length=45, nullable=false)
     */
    private $noTipoTransacao;


}

