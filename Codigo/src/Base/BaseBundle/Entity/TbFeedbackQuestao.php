<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFeedbackQuestao
 *
 * @ORM\Table(name="tb_feedback_questao", indexes={@ORM\Index(name="id_feedback", columns={"id_feedback"})})
 * @ORM\Entity
 */
class TbFeedbackQuestao extends AbstractEntity
{
    /**
     * @var integer
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
     * @var \TbFeedback
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFeedback")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_feedback", referencedColumnName="id_feedback")
     * })
     */
    private $idFeedback;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_posicao", type="integer", nullable=false)
     */
    private $nuPosicao;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbFeedbackQuestaoResposta", mappedBy="idFeedbackQuestao")
     */
    private $idFeedbackQuestaoResposta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idFeedbackQuestaoResposta = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdFeedbackQuestao()
    {
        return $this->idFeedbackQuestao;
    }

    /**
     * @param int $idFeedbackQuestao
     */
    public function setIdFeedbackQuestao($idFeedbackQuestao)
    {
        $this->idFeedbackQuestao = $idFeedbackQuestao;
    }

    /**
     * @return string
     */
    public function getNoQuestao()
    {
        return $this->noQuestao;
    }

    /**
     * @param string $noQuestao
     */
    public function setNoQuestao($noQuestao)
    {
        $this->noQuestao = $noQuestao;
    }

    /**
     * @return \TbFeedback
     */
    public function getIdFeedback()
    {
        return $this->idFeedback;
    }

    /**
     * @param \TbFeedback $idFeedback
     */
    public function setIdFeedback($idFeedback)
    {
        $this->idFeedback = $idFeedback;
    }

    /**
     * @return int
     */
    public function getNuPosicao()
    {
        return $this->nuPosicao;
    }

    /**
     * @param int $nuPosicao
     */
    public function setNuPosicao($nuPosicao)
    {
        $this->nuPosicao = $nuPosicao;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdFeedbackQuestaoResposta()
    {
        return $this->idFeedbackQuestaoResposta;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idFeedbackQuestaoResposta
     */
    public function setIdFeedbackQuestaoResposta($idFeedbackQuestaoResposta)
    {
        $this->idFeedbackQuestaoResposta = $idFeedbackQuestaoResposta;
    }
}