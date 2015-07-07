<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbConfiguracaoFranquiaNivel
 *
 * @ORM\Table(name="tb_configuracao_franquia_nivel", indexes={@ORM\Index(name="fk_configuracaofranquianivel_configuracaofranquia_idx", columns={"id_configuracao_franquia"})})
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
     * @ORM\Column(name="no_nivel", type="string", length=45, nullable=true)
     */
    private $noNivel;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_pontos_bonus_cadastro", type="integer", nullable=true)
     */
    private $nuPontosBonusCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_valor_bonus_cadastro", type="integer", nullable=true)
     */
    private $nuValorBonusCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_quantidade_pontos_necessaio", type="integer", nullable=true)
     */
    private $nuQuantidadePontosNecessaio;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_porcentagem_pontos_extra", type="integer", nullable=true)
     */
    private $nuPorcentagemPontosExtra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbConfiguracaoFranquia
     *
     * @ORM\ManyToOne(targetEntity="TbConfiguracaoFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_configuracao_franquia", referencedColumnName="id_configuracao_franquia")
     * })
     */
    private $idConfiguracaoFranquia;


}

