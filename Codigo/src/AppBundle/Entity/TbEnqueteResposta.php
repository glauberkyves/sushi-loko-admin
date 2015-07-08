<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEnqueteResposta
 *
 * @ORM\Table(name="tb_enquete_resposta", indexes={@ORM\Index(name="id_enquete", columns={"id_enquete"})})
 * @ORM\Entity
 */
class TbEnqueteResposta
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


}

