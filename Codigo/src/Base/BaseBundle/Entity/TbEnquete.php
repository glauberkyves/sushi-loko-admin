<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEnquete
 *
 * @ORM\Table(name="tb_enquete")
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\EnqueteRepository")
 */
class TbEnquete extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_enquete", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEnquete;

    /**
     * @var string
     *
     * @ORM\Column(name="no_enquete", type="string", length=45, nullable=false)
     */
    private $noEnquete;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_inicio", type="datetime", nullable=false)
     */
    private $dtInicio;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var integer
     *
     * @ORM\Column(name="nu_pontos", type="integer", nullable=false)
     */
    private $nuPontos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_fim", type="datetime", nullable=false)
     */
    private $dtFim;

    /**
     * @var string
     *
     * @ORM\Column(name="no_pergunta", type="text", length=65535, nullable=false)
     */
    private $noPergunta;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_bonus", type="text", length=250, nullable=false)
     */
    private $nuBonus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbEnqueteResposta", mappedBy="idEnquete")
     */
    private $idResposta;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idResposta = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdResposta()
    {
        return $this->idResposta;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idResposta
     */
    public function setIdResposta($idResposta)
    {
        $this->idResposta = $idResposta;
    }



    /**
     * @return int
     */
    public function getIdEnquete()
    {
        return $this->idEnquete;
    }

    /**
     * @param int $idEnquete
     */
    public function setIdEnquete($idEnquete)
    {
        $this->idEnquete = $idEnquete;
    }

    /**
     * @return string
     */
    public function getNoEnquete()
    {
        return $this->noEnquete;
    }

    /**
     * @param string $noEnquete
     */
    public function setNoEnquete($noEnquete)
    {
        $this->noEnquete = $noEnquete;
    }

    /**
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * @param \DateTime $dtInicio
     */
    public function setDtInicio($dtInicio)
    {
        $this->dtInicio = $dtInicio;
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
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * @param \DateTime $dtFim
     */
    public function setDtFim($dtFim)
    {
        $this->dtFim = $dtFim;
    }

    /**
     * @return string
     */
    public function getNoPergunta()
    {
        return $this->noPergunta;
    }

    /**
     * @param string $noPergunta
     */
    public function setNoPergunta($noPergunta)
    {
        $this->noPergunta = $noPergunta;
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
    public function getNuPontos()
    {
        return $this->nuPontos;
    }

    /**
     * @param int $nuPontos
     */
    public function setNuPontos($nuPontos)
    {
        $this->nuPontos = $nuPontos;
    }

    /**
     * @return string
     */
    public function getNuBonus()
    {
        return $this->nuBonus;
    }

    /**
     * @param string $nuBonus
     */
    public function setNuBonus($nuBonus)
    {
        $this->nuBonus = $nuBonus;
    }


}

