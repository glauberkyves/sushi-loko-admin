<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquia
 *
 * @ORM\Table(name="tb_franquia")
 * @ORM\Entity
 */
class TbFranquia extends AbstractEntity
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

    /**
     * @return int
     */
    public function getIdFranquia()
    {
        return $this->idFranquia;
    }

    /**
     * @param int $idFranquia
     */
    public function setIdFranquia($idFranquia)
    {
        $this->idFranquia = $idFranquia;
    }

    /**
     * @return int
     */
    public function getIdEndereco()
    {
        return $this->idEndereco;
    }

    /**
     * @param int $idEndereco
     */
    public function setIdEndereco($idEndereco)
    {
        $this->idEndereco = $idEndereco;
    }

    /**
     * @return string
     */
    public function getNoFranquia()
    {
        return $this->noFranquia;
    }

    /**
     * @param string $noFranquia
     */
    public function setNoFranquia($noFranquia)
    {
        $this->noFranquia = $noFranquia;
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
}

