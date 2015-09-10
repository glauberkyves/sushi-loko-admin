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
     * @var int
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
     * @var int
     *
     * @ORM\Column(name="nu_pontos_bonus_cadastro", type="integer", nullable=true)
     */
    private $nuPontosBonusCadastro;

    /**
     * @var int
     *
     * @ORM\Column(name="nu_valor_bonus_cadastro", type="integer", nullable=true)
     */
    private $nuValorBonusCadastro;

    /**
     * @var int
     *
     * @ORM\Column(name="nu_quantidade_pontos_necessaio", type="integer", nullable=true)
     */
    private $nuQuantidadePontosNecessaio;

    /**
     * @var int
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
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;


}

