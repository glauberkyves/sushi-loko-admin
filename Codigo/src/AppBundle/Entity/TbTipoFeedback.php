<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTipoFeedback
 *
 * @ORM\Table(name="tb_tipo_feedback")
 * @ORM\Entity
 */
class TbTipoFeedback
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_feedback", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTipoFeedback;

    /**
     * @var string
     *
     * @ORM\Column(name="no_tipo_feedback", type="string", length=150, nullable=false)
     */
    private $noTipoFeedback;


}

