<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTipoFeedback
 *
 * @ORM\Table(name="tb_tipo_feedback")
 * @ORM\Entity
 */
class TbTipoFeedback extends AbstractEntity
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

    /**
     * @return int
     */
    public function getIdTipoFeedback()
    {
        return $this->idTipoFeedback;
    }

    /**
     * @param int $idTipoFeedback
     */
    public function setIdTipoFeedback($idTipoFeedback)
    {
        $this->idTipoFeedback = $idTipoFeedback;
    }

    /**
     * @return string
     */
    public function getNoTipoFeedback()
    {
        return $this->noTipoFeedback;
    }

    /**
     * @param string $noTipoFeedback
     */
    public function setNoTipoFeedback($noTipoFeedback)
    {
        $this->noTipoFeedback = $noTipoFeedback;
    }
}
