<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFeedback
 *
 * @ORM\Table(name="tb_feedback", indexes={@ORM\Index(name="fk_feedback_franqueador_idx", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbFeedback
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_feedback", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFeedback;

    /**
     * @var string
     *
     * @ORM\Column(name="no_feedback", type="string", length=45, nullable=true)
     */
    private $noFeedback;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_inicio", type="datetime", nullable=true)
     */
    private $dtInicio;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_feedback", type="text", length=65535, nullable=true)
     */
    private $dsFeedback;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=true)
     */
    private $dtCadastro;

    /**
     * @var int
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;


}

