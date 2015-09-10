<?php

namespace Base\BaseBundle\Entity;

use Base\BaseBundle\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * TbFeedback
 *
 * @ORM\Table(name="tb_feedback", indexes={@ORM\Index(name="fk_feedback_franqueador_idx", columns={"id_franqueador"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\FeedbackRepository")
 */
class TbFeedback extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_feedback", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFeedback;

    /**
     * @var string
     *
     * @ORM\Column(name="no_feedback", type="string", length=45, nullable=false)
     */
    private $noFeedback;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_inicio", type="datetime", nullable=false)
     */
    private $dtInicio;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_feedback", type="text", length=65535, nullable=false)
     */
    private $dsFeedback;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbFeedbackQuestao", mappedBy="idFeedback")
     */
    private $idFeedbackQuestao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idFeedbackQuestao = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return \TbFranqueador
     */
    public function getIdFranqueador()
    {
        return $this->idFranqueador;
    }

    /**
     * @param \TbFranqueador $idFranqueador
     */
    public function setIdFranqueador($idFranqueador)
    {
        $this->idFranqueador = $idFranqueador;
    }

    /**
     * @return int
     */
    public function getIdFeedback()
    {
        return $this->idFeedback;
    }

    /**
     * @param int $idFeedback
     */
    public function setIdFeedback($idFeedback)
    {
        $this->idFeedback = $idFeedback;
    }

    /**
     * @return string
     */
    public function getNoFeedback()
    {
        return $this->noFeedback;
    }

    /**
     * @param string $noFeedback
     */
    public function setNoFeedback($noFeedback)
    {
        $this->noFeedback = $noFeedback;
    }

    /**
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * @param \DateTime $dtInicio
     */
    public function setDtInicio($dtInicio)
    {
        $this->dtInicio = $dtInicio;
    }

    /**
     * @return string
     */
    public function getDsFeedback()
    {
        return $this->dsFeedback;
    }

    /**
     * @param string $dsFeedback
     */
    public function setDsFeedback($dsFeedback)
    {
        $this->dsFeedback = $dsFeedback;
    }

    /**
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * @param \DateTime $dtCadastro
     */
    public function setDtCadastro($dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
    }

    /**
     * @return int
     */
    public function getStAtivo()
    {
        return $this->stAtivo;
    }

    /**
     * @param int $stAtivo
     */
    public function setStAtivo($stAtivo)
    {
        $this->stAtivo = $stAtivo;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdFeedbackQuestao()
    {
        return $this->idFeedbackQuestao;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idFeedbackQuestao
     */
    public function setIdFeedbackQuestao($idFeedbackQuestao)
    {
        $this->idFeedbackQuestao = $idFeedbackQuestao;
    }
}

