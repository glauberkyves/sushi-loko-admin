<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbPerfil
 *
 * @ORM\Table(name="tb_perfil")
 * @ORM\Entity
 */
class TbPerfil extends AbstractEntity
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

    /**
     * @return int
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }

    /**
     * @param int $idPerfil
     */
    public function setIdPerfil($idPerfil)
    {
        $this->idPerfil = $idPerfil;
    }

    /**
     * @return string
     */
    public function getNoPerfil()
    {
        return $this->noPerfil;
    }

    /**
     * @param string $noPerfil
     */
    public function setNoPerfil($noPerfil)
    {
        $this->noPerfil = $noPerfil;
    }

    /**
     * @return string
     */
    public function getSgPerfil()
    {
        return $this->sgPerfil;
    }

    /**
     * @param string $sgPerfil
     */
    public function setSgPerfil($sgPerfil)
    {
        $this->sgPerfil = $sgPerfil;
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
     * @return \DateTime
     */
    public function getDtAtualizacao()
    {
        return $this->dtAtualizacao;
    }

    /**
     * @param \DateTime $dtAtualizacao
     */
    public function setDtAtualizacao($dtAtualizacao)
    {
        $this->dtAtualizacao = $dtAtualizacao;
    }



}

