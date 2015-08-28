<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 28/08/2015
 * Time: 14:40
 */

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pesquisa
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\PesquisaRepository")
 */
class Pesquisa extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column()
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPesquisa;

    /**
     * @var string
     */
    private $sgSexo;

    /**
     * @var integer
     */
    private $nuIdadeMin;

    /**
     * @var integer
     */
    private $nuIdadeMax;

    /**
     * @var string
     */
    private $idFranqueado;

    /**
     * @var integer
     */
    private $nuPeriodo;

    /**
     * @var string
     */
    private $noPeriodo;

    /**
     * @var integer
     */
    private $nuBonusPeriodo;

    /**
     * @var string
     */
    private $noBonusPeriodo;

    /**
     * @var integer
     */
    private $nuBonusTransacionado;

    /**
     * @var string
     */
    private $noBonusTransacionado;

    /**
     * @var string
     */
    private $noSaldoBonus;

    /**
     * @var integer
     */
    private $nuSaldoBonus;

    /**
     * @var integer
     */
    private $nuCadastro;

    /**
     * @var string
     */
    private $noCadastro;

    /**
     * @var string
     */
    private $noMediaConsumo;

    /**
     * @var integer
     */
    private $nuMediaConsumo;

    /**
     * @var integer
     */
    private $nuConsumoTotal;

    /**
     * @var integer
     */
    private $nuAniversariante;

    /**
     * @return int
     */
    public function getIdPesquisa()
    {
        return $this->idPesquisa;
    }

    /**
     * @param int $idPesquisa
     */
    public function setIdPesquisa($idPesquisa)
    {
        $this->idPesquisa = $idPesquisa;
    }

    /**
     * @return string
     */
    public function getSgSexo()
    {
        return $this->sgSexo;
    }

    /**
     * @param string $sgSexo
     */
    public function setSgSexo($sgSexo)
    {
        $this->sgSexo = $sgSexo;
    }

    /**
     * @return int
     */
    public function getNuIdadeMin()
    {
        return $this->nuIdadeMin;
    }

    /**
     * @param int $nuIdadeMin
     */
    public function setNuIdadeMin($nuIdadeMin)
    {
        $this->nuIdadeMin = $nuIdadeMin;
    }

    /**
     * @return int
     */
    public function getNuIdadeMax()
    {
        return $this->nuIdadeMax;
    }

    /**
     * @param int $nuIdadeMax
     */
    public function setNuIdadeMax($nuIdadeMax)
    {
        $this->nuIdadeMax = $nuIdadeMax;
    }

    /**
     * @return string
     */
    public function getIdFranqueado()
    {
        return $this->idFranqueado;
    }

    /**
     * @param string $idFranqueado
     */
    public function setIdFranqueado($idFranqueado)
    {
        $this->idFranqueado = $idFranqueado;
    }

    /**
     * @return int
     */
    public function getNuPeriodo()
    {
        return $this->nuPeriodo;
    }

    /**
     * @param int $nuPeriodo
     */
    public function setNuPeriodo($nuPeriodo)
    {
        $this->nuPeriodo = $nuPeriodo;
    }

    /**
     * @return string
     */
    public function getNoPeriodo()
    {
        return $this->noPeriodo;
    }

    /**
     * @param string $noPeriodo
     */
    public function setNoPeriodo($noPeriodo)
    {
        $this->noPeriodo = $noPeriodo;
    }

    /**
     * @return int
     */
    public function getNuBonusPeriodo()
    {
        return $this->nuBonusPeriodo;
    }

    /**
     * @param int $nuBonusPeriodo
     */
    public function setNuBonusPeriodo($nuBonusPeriodo)
    {
        $this->nuBonusPeriodo = $nuBonusPeriodo;
    }

    /**
     * @return string
     */
    public function getNoBonusPeriodo()
    {
        return $this->noBonusPeriodo;
    }

    /**
     * @param string $noBonusPeriodo
     */
    public function setNoBonusPeriodo($noBonusPeriodo)
    {
        $this->noBonusPeriodo = $noBonusPeriodo;
    }

    /**
     * @return int
     */
    public function getNuBonusTransacionado()
    {
        return $this->nuBonusTransacionado;
    }

    /**
     * @param int $nuBonusTransacionado
     */
    public function setNuBonusTransacionado($nuBonusTransacionado)
    {
        $this->nuBonusTransacionado = $nuBonusTransacionado;
    }

    /**
     * @return string
     */
    public function getNoBonusTransacionado()
    {
        return $this->noBonusTransacionado;
    }

    /**
     * @param string $noBonusTransacionado
     */
    public function setNoBonusTransacionado($noBonusTransacionado)
    {
        $this->noBonusTransacionado = $noBonusTransacionado;
    }

    /**
     * @return string
     */
    public function getNoSaldoBonus()
    {
        return $this->noSaldoBonus;
    }

    /**
     * @param string $noSaldoBonus
     */
    public function setNoSaldoBonus($noSaldoBonus)
    {
        $this->noSaldoBonus = $noSaldoBonus;
    }

    /**
     * @return int
     */
    public function getNuSaldoBonus()
    {
        return $this->nuSaldoBonus;
    }

    /**
     * @param int $nuSaldoBonus
     */
    public function setNuSaldoBonus($nuSaldoBonus)
    {
        $this->nuSaldoBonus = $nuSaldoBonus;
    }

    /**
     * @return int
     */
    public function getNuCadastro()
    {
        return $this->nuCadastro;
    }

    /**
     * @param int $nuCadastro
     */
    public function setNuCadastro($nuCadastro)
    {
        $this->nuCadastro = $nuCadastro;
    }

    /**
     * @return string
     */
    public function getNoCadastro()
    {
        return $this->noCadastro;
    }

    /**
     * @param string $noCadastro
     */
    public function setNoCadastro($noCadastro)
    {
        $this->noCadastro = $noCadastro;
    }

    /**
     * @return string
     */
    public function getNoMediaConsumo()
    {
        return $this->noMediaConsumo;
    }

    /**
     * @param string $noMediaConsumo
     */
    public function setNoMediaConsumo($noMediaConsumo)
    {
        $this->noMediaConsumo = $noMediaConsumo;
    }

    /**
     * @return int
     */
    public function getNuMediaConsumo()
    {
        return $this->nuMediaConsumo;
    }

    /**
     * @param int $nuMediaConsumo
     */
    public function setNuMediaConsumo($nuMediaConsumo)
    {
        $this->nuMediaConsumo = $nuMediaConsumo;
    }

    /**
     * @return int
     */
    public function getNuConsumoTotal()
    {
        return $this->nuConsumoTotal;
    }

    /**
     * @param int $nuConsumoTotal
     */
    public function setNuConsumoTotal($nuConsumoTotal)
    {
        $this->nuConsumoTotal = $nuConsumoTotal;
    }

    /**
     * @return int
     */
    public function getNuAniversariante()
    {
        return $this->nuAniversariante;
    }

    /**
     * @param int $nuAniversariante
     */
    public function setNuAniversariante($nuAniversariante)
    {
        $this->nuAniversariante = $nuAniversariante;
    }
}