<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbBonus
 *
 * @ORM\Table(name="tb_bonus", indexes={@ORM\Index(name="fk_bonus_franqueadorusuario_idx", columns={"id_franqueador_usuario"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\BonusRepository")
 */
class TbBonus extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_bonus", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_bonus", type="integer", nullable=false)
     */
    private $nuBonus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_vencido", type="integer", nullable=false)
     */
    private $stVencido;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \TbFranqueadorUsuario
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueadorUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador_usuario", referencedColumnName="id_franqueador_usuario")
     * })
     */
    private $idFranqueadorUsuario;

    /**
     * @return int
     */
    public function getIdBonus()
    {
        return $this->idBonus;
    }

    /**
     * @param int $idBonus
     */
    public function setIdBonus($idBonus)
    {
        $this->idBonus = $idBonus;
    }

    /**
     * @return int
     */
    public function getNuBonus()
    {
        return $this->nuBonus;
    }

    /**
     * @param int $nuBonus
     */
    public function setNuBonus($nuBonus)
    {
        $this->nuBonus = $nuBonus;
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
     * @return int
     */
    public function getStAtivo()
    {
        return $this->stAtivo;
    }

    /**
     * @param int $stAtivo
     */
    public function setStAtivo($stAtivo)
    {
        $this->stAtivo = $stAtivo;
    }

    /**
     * @return \TbFranqueadorUsuario
     */
    public function getIdFranqueadorUsuario()
    {
        return $this->idFranqueadorUsuario;
    }

    /**
     * @param \TbFranqueadorUsuario $idFranqueadorUsuario
     */
    public function setIdFranqueadorUsuario($idFranqueadorUsuario)
    {
        $this->idFranqueadorUsuario = $idFranqueadorUsuario;
    }

    /**
     * @return int
     */
    public function getStVencido()
    {
        return $this->stVencido;
    }

    /**
     * @param int $stVencido
     */
    public function setStVencido($stVencido)
    {
        $this->stVencido = $stVencido;
    }
}

