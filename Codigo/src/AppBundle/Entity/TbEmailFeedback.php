<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEmailFeedback
 *
 * @ORM\Table(name="tb_email_feedback", indexes={@ORM\Index(name="id_franqueador", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbEmailFeedback
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_email_fedback", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEmailFedback;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_mensagem", type="text", length=65535, nullable=false)
     */
    private $dsMensagem;

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

