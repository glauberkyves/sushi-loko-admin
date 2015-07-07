<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbQuestaoEnquete
 *
 * @ORM\Table(name="tb_questao_enquete")
 * @ORM\Entity
 */
class TbQuestaoEnquete
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_questao_enquete", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idQuestaoEnquete;

    /**
     * @var string
     *
     * @ORM\Column(name="no_questao_enquete", type="text", length=65535, nullable=false)
     */
    private $noQuestaoEnquete;

    /**
     * @var string
     *
     * @ORM\Column(name="qt_votos", type="string", length=45, nullable=false)
     */
    private $qtVotos;


}

