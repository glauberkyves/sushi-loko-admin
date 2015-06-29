<?php

namespace Base\BaseBundle\Entity;

use Base\BaseBundle\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * TbResposta
 *
 * @ORM\Table(name="tb_resposta", indexes={@ORM\Index(name="id_enquete", columns={"id_enquete"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\RespostaRepository")
 */
class TbResposta extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_resposta", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idResposta;

    /**
     * @var string
     *
     * @ORM\Column(name="no_resposta", type="text", length=65535, nullable=false)
     */
    private $noResposta;

    /**
     * @var \TbEnquete
     *
     * @ORM\ManyToOne(targetEntity="TbEnquete")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_enquete", referencedColumnName="id_enquete")
     * })
     */
    private $idEnquete;


    /**
     * @return int
     */
    public function getIdResposta()
    {
        return $this->idResposta;
    }

    /**
     * @param int $idResposta
     */
    public function setIdResposta($idResposta)
    {
        $this->idResposta = $idResposta;
    }

    /**
     * @return int
     */
    public function getIdEnquete()
    {
        return $this->idEnquete;
    }

    /**
     * @param int $idEnquete
     */
    public function setIdEnquete($idEnquete)
    {
        $this->idEnquete = $idEnquete;
    }

    /**
     * @return string
     */
    public function getNoResposta()
    {
        return $this->noResposta;
    }

    /**
     * @param string $noResposta
     */
    public function setNoResposta($noResposta)
    {
        $this->noResposta = $noResposta;
    }


}

