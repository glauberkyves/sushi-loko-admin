<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFeedbackQuestaoResposta
 *
 * @ORM\Table(name="tb_feedback_questao_resposta", indexes={@ORM\Index(name="id_usuario", columns={"id_usuario"}), @ORM\Index(name="id_feedback_questao", columns={"id_feedback_questao"}), @ORM\Index(name="id_franquia", columns={"id_franquia"}), @ORM\Index(name="id_tipo_feedback", columns={"id_tipo_feedback"})})
 * @ORM\Entity
 */
class TbFeedbackQuestaoResposta
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
     * @ORM\ManyToOne(targetEntity="TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;

    /**
     * @var \TbFeedbackQuestao
     *
     * @ORM\ManyToOne(targetEntity="TbFeedbackQuestao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_feedback_questao", referencedColumnName="id_feedback_questao")
     * })
     */
    private $idFeedbackQuestao;

    /**
     * @var \TbFranquia
     *
     * @ORM\ManyToOne(targetEntity="TbFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franquia", referencedColumnName="id_franquia")
     * })
     */
    private $idFranquia;

    /**
     * @var \TbTipoFeedback
     *
     * @ORM\ManyToOne(targetEntity="TbTipoFeedback")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_feedback", referencedColumnName="id_tipo_feedback")
     * })
     */
    private $idTipoFeedback;


}

