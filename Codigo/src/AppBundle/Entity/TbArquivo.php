<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbArquivo
 *
 * @ORM\Table(name="tb_arquivo")
 * @ORM\Entity
 */
class TbArquivo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_arquivo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArquivo;

    /**
     * @var string
     *
     * @ORM\Column(name="no_arquivo", type="string", length=100, nullable=false)
     */
    private $noArquivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_processamento", type="datetime", nullable=false)
     */
    private $dtProcessamento;

    /**
     * @var string
     *
     * @ORM\Column(name="no_blob_arquivo", type="blob", length=65535, nullable=false)
     */
    private $noBlobArquivo;


}

