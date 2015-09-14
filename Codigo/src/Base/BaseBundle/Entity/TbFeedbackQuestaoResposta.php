<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFeedbackQuestaoResposta
 *
 * @ORM\Table(name="tb_feedback_questao_resposta", indexes={@ORM\Index(name="id_usuario", columns={"id_usuario"}), @ORM\Index(name="id_feedback_questao", columns={"id_feedback_questao"}), @ORM\Index(name="id_franquia", columns={"id_franquia"}), @ORM\Index(name="id_tipo_feedback", columns={"id_tipo_feedback"})})
 * @ORM\Entity
 */
class TbFeedbackQuestaoResposta extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_feedback_questao_resposta", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFeedbackQuestaoResposta;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_resposta", type="integer", nullable=true)
     */
    private $nuResposta;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_resposta", type="text", length=65535, nullable=true)
     */
    private $dsResposta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;

    /**
     * @var \TbFeedbackQuestao
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFeedbackQuestao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_feedback_questao", referencedColumnName="id_feedback_questao")
     * })
     */
    private $idFeedbackQuestao;

    /**
     * @var \TbFranquia
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franquia", referencedColumnName="id_franquia")
     * })
     */
    private $idFranquia;

    /**
     * @var \TbTipoFeedback
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbTipoFeedback")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_feedback", referencedColumnName="id_tipo_feedback")
     * })
     */
    private $idTipoFeedback;

    /**
     * @return int
     */
    public function getIdFeedbackQuestaoResposta()
    {
        return $this->idFeedbackQuestaoResposta;
    }

    /**
     * @param int $idFeedbackQuestaoResposta
     */
    public function setIdFeedbackQuestaoResposta($idFeedbackQuestaoResposta)
    {
        $this->idFeedbackQuestaoResposta = $idFeedbackQuestaoResposta;
    }

    /**
     * @return int
     */
    public function getNuResposta()
    {
        return $this->nuResposta;
    }

    /**
     * @param int $nuResposta
     */
    public function setNuResposta($nuResposta)
    {
        $this->nuResposta = $nuResposta;
    }

    /**
     * @return string
     */
    public function getDsResposta()
    {
        return $this->dsResposta;
    }

    /**
     * @param string $dsResposta
     */
    public function setDsResposta($dsResposta)
    {
        $this->dsResposta = $dsResposta;
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
     * @return \TbUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param \TbUsuario $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return \TbFeedbackQuestao
     */
    public function getIdFeedbackQuestao()
    {
        return $this->idFeedbackQuestao;
    }

    /**
     * @param \TbFeedbackQuestao $idFeedbackQuestao
     */
    public function setIdFeedbackQuestao($idFeedbackQuestao)
    {
        $this->idFeedbackQuestao = $idFeedbackQuestao;
    }

    /**
     * @return \TbFranquia
     */
    public function getIdFranquia()
    {
        return $this->idFranquia;
    }

    /**
     * @param \TbFranquia $idFranquia
     */
    public function setIdFranquia($idFranquia)
    {
        $this->idFranquia = $idFranquia;
    }

    /**
     * @return \TbTipoFeedback
     */
    public function getIdTipoFeedback()
    {
        return $this->idTipoFeedback;
    }

    /**
     * @param \TbTipoFeedback $idTipoFeedback
     */
    public function setIdTipoFeedback($idTipoFeedback)
    {
        $this->idTipoFeedback = $idTipoFeedback;
    }
}