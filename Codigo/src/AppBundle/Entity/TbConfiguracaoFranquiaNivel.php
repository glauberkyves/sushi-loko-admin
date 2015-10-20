<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbConfiguracaoFranquiaNivel
 *
 * @ORM\Table(name="tb_configuracao_franquia_nivel", indexes={@ORM\Index(name="fk_configuracaofranquianivel_franqueador_idx", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbConfiguracaoFranquiaNivel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_configuracao_franquia_nivel", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idConfiguracaoFranquiaNivel;

    /**
     * @var string
     *
     * @ORM\Column(name="no_nivel", type="string", length=45, nullable=false)
     */
    private $noNivel;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_quantidade_pontos_necessaio", type="integer", nullable=false)
     */
    private $nuQuantidadePontosNecessaio;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_porcentagem_pontos_extra", type="integer", nullable=false)
     */
    private $nuPorcentagemPontosExtra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_quantidade_pontos_por_atingir", type="integer", nullable=false)
     */
    private $nuQuantidadePontosPorAtingir;

    /**
     * @var string
     *
     * @ORM\Column(name="no_imagem", type="string", length=100, nullable=true)
     */
    private $noImagem;

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

