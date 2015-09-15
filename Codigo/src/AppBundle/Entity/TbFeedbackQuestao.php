<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFeedbackQuestao
 *
 * @ORM\Table(name="tb_feedback_questao", indexes={@ORM\Index(name="id_feedback", columns={"id_feedback"})})
 * @ORM\Entity
 */
class TbFeedbackQuestao
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_feedback_questao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFeedbackQuestao;

    /**
     * @var string
     *
     * @ORM\Column(name="no_questao", type="string", length=250, nullable=false)
     */
    private $noQuestao;

    /**
     * @var int
     *
     * @ORM\Column(name="nu_posicao", type="integer", nullable=false)
     */
    private $nuPosicao;

    /**
     * @var \TbFeedback
     *
     * @ORM\ManyToOne(targetEntity="TbFeedback")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_feedback", referencedColumnName="id_feedback")
     * })
     */
    private $idFeedback;


}

