<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueadorUsuario
 *
 * @ORM\Table(name="tb_franqueador_usuario", indexes={@ORM\Index(name="id_franqueador", columns={"id_franqueador"}), @ORM\Index(name="id_usuario", columns={"id_usuario"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\FranqueadorUsuarioRepository")
 */
class TbFranqueadorUsuario extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franqueador_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranqueadorUsuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

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
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;

    /**
     * @var \TbUsuario
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbFranqueadorComentarioUsuario", mappedBy="idFranqueadorUsuario")
     */
    private $idFranqueadorComentario;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbBonus", mappedBy="idFranqueadorUsuario")
     */
    private $idBonus;

    /**
     * @return int
     */
    public function getIdFranqueadorUsuario()
    {
        return $this->idFranqueadorUsuario;
    }

    /**
     * @param int $idFranqueadorUsuario
     */
    public function setIdFranqueadorUsuario($idFranqueadorUsuario)
    {
        $this->idFranqueadorUsuario = $idFranqueadorUsuario;
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
     * @return \TbUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param \TbUsuario $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return \TbUsuario
     */
    public function getIdFranqueadorComentario()
    {
        return $this->idFranqueadorComentario;
    }

    /**
     * @param \TbUsuario $idFranqueadorComentario
     */
    public function setIdFranqueadorComentario($idFranqueadorComentario)
    {
        $this->idFranqueadorComentario = $idFranqueadorComentario;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdBonus()
    {
        return $this->idBonus;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idBonus
     */
    public function setIdBonus($idBonus)
    {
        $this->idBonus = $idBonus;
    }


}

