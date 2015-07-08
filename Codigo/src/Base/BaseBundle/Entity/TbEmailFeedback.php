<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEmailFeedback
 *
 * @ORM\Table(name="tb_email_feedback", indexes={@ORM\Index(name="id_franqueador", columns={"id_franqueador"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\EmailFeedbackRepository")
 */
class TbEmailFeedback extends AbstractEntity
{
    /**
     * @var integer
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

    /**
     * @return int
     */
    public function getIdEmailFedback()
    {
        return $this->idEmailFedback;
    }

    /**
     * @param int $idEmailFedback
     */
    public function setIdEmailFedback($idEmailFedback)
    {
        $this->idEmailFedback = $idEmailFedback;
    }



    /**
     * @return string
     */
    public function getDsMensagem()
    {
        return $this->dsMensagem;
    }

    /**
     * @param string $dsMensagem
     */
    public function setDsMensagem($dsMensagem)
    {
        $this->dsMensagem = $dsMensagem;
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


}

