<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RlUsuarioPerfil
 *
 * @ORM\Table(name="rl_usuario_perfil", indexes={@ORM\Index(name="fk_usuarioperfil_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_usuarioperfil_perfil_idx", columns={"id_perfil"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\UsuarioPerfilRepository")
 */
class RlUsuarioPerfil extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_usuario_perfil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsuarioPerfil;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbPerfil
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbPerfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     * })
     */
    private $idPerfil;

    /**
     * @var \TbUsuario
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbUsuario", inversedBy="rlUsuarioPerfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;

    /**
     * @return int
     */
    public function getIdUsuarioPerfil()
    {
        return $this->idUsuarioPerfil;
    }

    /**
     * @return \Base\BaseBundle\Entity\TbUsuario
     */
    public function setIdUsuarioPerfil($idUsuarioPerfil)
    {
        $this->idUsuarioPerfil = $idUsuarioPerfil;
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
     * @return \TbPerfil
     */
    public function getIdPerfil()
    {
        return $this->idPerfil ? $this->idPerfil: new TbPerfil();
    }

    /**
     * @param \TbPerfil $idPerfil
     */
    public function setIdPerfil($idPerfil)
    {
        $this->idPerfil = $idPerfil;
    }

    /**
     * @return \TbUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario ? $this->idUsuario: new TbUsuario();
    }

    /**
     * @param \TbUsuario $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }


}

