<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbConfiguracaoFranquia
 *
 * @ORM\Table(name="tb_configuracao_franquia")
 * @ORM\Entity
 */
class TbConfiguracaoFranquia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_configuracao_franquia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idConfiguracaoFranquia;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_valor_minimo_resgate", type="integer", nullable=true)
     */
    private $nuValorMinimoResgate;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_pontos_transacao", type="integer", nullable=true)
     */
    private $nuPontosTransacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_porcentagem_bonus_transacao", type="integer", nullable=true)
     */
    private $nuPorcentagemBonusTransacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_validade_bonus", type="datetime", nullable=true)
     */
    private $dtValidadeBonus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;


}

