<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbPerfil
 *
 * @ORM\Table(name="tb_perfil")
 * @ORM\Entity
 */
class TbPerfil
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_perfil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="no_perfil", type="string", length=100, nullable=false)
     */
    private $noPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="sg_perfil", type="string", length=45, nullable=false)
     */
    private $sgPerfil;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_atualizacao", type="datetime", nullable=true)
     */
    private $dtAtualizacao;


}

