<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbConfiguracaoFranquiaNivel
 *
 * @ORM\Table(name="tb_configuracao_franquia_nivel", indexes={@ORM\Index(name="fk_configuracaofranquianivel_franqueador_idx", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbConfiguracaoFranquiaNivel extends AbstractEntity
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
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;

    /**
     * @return int
     */
    public function getIdConfiguracaoFranquiaNivel()
    {
        return $this->idConfiguracaoFranquiaNivel;
    }

    /**
     * @param int $idConfiguracaoFranquiaNivel
     */
    public function setIdConfiguracaoFranquiaNivel($idConfiguracaoFranquiaNivel)
    {
        $this->idConfiguracaoFranquiaNivel = $idConfiguracaoFranquiaNivel;
    }

    /**
     * @return string
     */
    public function getNoNivel()
    {
        return $this->noNivel;
    }

    /**
     * @param string $noNivel
     */
    public function setNoNivel($noNivel)
    {
        $this->noNivel = $noNivel;
    }

    /**
     * @return int
     */
    public function getNuPontosBonusCadastro()
    {
        return $this->nuPontosBonusCadastro;
    }

    /**
     * @param int $nuPontosBonusCadastro
     */
    public function setNuPontosBonusCadastro($nuPontosBonusCadastro)
    {
        $this->nuPontosBonusCadastro = $nuPontosBonusCadastro;
    }

    /**
     * @return int
     */
    public function getNuValorBonusCadastro()
    {
        return $this->nuValorBonusCadastro;
    }

    /**
     * @param int $nuValorBonusCadastro
     */
    public function setNuValorBonusCadastro($nuValorBonusCadastro)
    {
        $this->nuValorBonusCadastro = $nuValorBonusCadastro;
    }

    /**
     * @return int
     */
    public function getNuQuantidadePontosNecessaio()
    {
        return $this->nuQuantidadePontosNecessaio;
    }

    /**
     * @param int $nuQuantidadePontosNecessaio
     */
    public function setNuQuantidadePontosNecessaio($nuQuantidadePontosNecessaio)
    {
        $this->nuQuantidadePontosNecessaio = $nuQuantidadePontosNecessaio;
    }

    /**
     * @return int
     */
    public function getNuPorcentagemPontosExtra()
    {
        return $this->nuPorcentagemPontosExtra;
    }

    /**
     * @param int $nuPorcentagemPontosExtra
     */
    public function setNuPorcentagemPontosExtra($nuPorcentagemPontosExtra)
    {
        $this->nuPorcentagemPontosExtra = $nuPorcentagemPontosExtra;
    }

    /**
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * @param \DateTime $dtCadastro
     */
    public function setDtCadastro($dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
    }

    /**
     * @return \TbFranqueador
     */
    public function getIdFranqueador()
    {
        return $this->idFranqueador;
    }

    /**
     * @param \TbFranqueador $idFranqueador
     */
    public function setIdFranqueador($idFranqueador)
    {
        $this->idFranqueador = $idFranqueador;
    }

    /**
     * @return int
     */
    public function getNuQuantidadePontosPorAtingir()
    {
        return $this->nuQuantidadePontosPorAtingir;
    }

    /**
     * @param int $nuQuantidadePontosPorAtingir
     */
    public function setNuQuantidadePontosPorAtingir($nuQuantidadePontosPorAtingir)
    {
        $this->nuQuantidadePontosPorAtingir = $nuQuantidadePontosPorAtingir;
    }

    /**
     * @return string
     */
    public function getNoImagem()
    {
        return $this->noImagem;
    }

    /**
     * @param string $noImagem
     */
    public function setNoImagem($noImagem)
    {
        $this->noImagem = $noImagem;
    }


}

