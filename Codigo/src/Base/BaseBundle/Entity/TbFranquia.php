<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquia
 *
 * @ORM\Table(name="tb_franquia")
 * @ORM\Entity
 */
class TbFranquia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franquia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranquia;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_endereco", type="integer", nullable=true)
     */
    private $idEndereco;

    /**
     * @var string
     *
     * @ORM\Column(name="no_franquia", type="string", length=100, nullable=true)
     */
    private $noFranquia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=true)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=true)
     */
    private $stAtivo;


}

