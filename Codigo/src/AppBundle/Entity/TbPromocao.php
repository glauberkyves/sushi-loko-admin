<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbPromocao
 *
 * @ORM\Table(name="tb_promocao", indexes={@ORM\Index(name="id_franqueador", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbPromocao
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_promocao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPromocao;

    /**
     * @var string
     *
     * @ORM\Column(name="no_promocao", type="string", length=100, nullable=false)
     */
    private $noPromocao;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_promocao", type="text", length=65535, nullable=false)
     */
    private $dsPromocao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_validade", type="datetime", nullable=false)
     */
    private $dtValidade;

    /**
     * @var string
     *
     * @ORM\Column(name="no_imagem", type="string", length=100, nullable=true)
     */
    private $noImagem;

    /**
     * @var int
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
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;


}

