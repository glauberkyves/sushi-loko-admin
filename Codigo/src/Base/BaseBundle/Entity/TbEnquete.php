<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEnquete
 *
 * @ORM\Table(name="tb_enquete")
 * @ORM\Entity
 */
class TbEnquete
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_enquete", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEnquete;

    /**
     * @var string
     *
     * @ORM\Column(name="no_enquete", type="string", length=45, nullable=false)
     */
    private $noEnquete;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_inicio", type="datetime", nullable=false)
     */
    private $dtInicio;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_fim", type="datetime", nullable=false)
     */
    private $dtFim;

    /**
     * @var string
     *
     * @ORM\Column(name="no_pergunta", type="text", length=65535, nullable=false)
     */
    private $noPergunta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;


}

