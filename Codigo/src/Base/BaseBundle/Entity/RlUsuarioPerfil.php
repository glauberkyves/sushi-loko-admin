<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RlUsuarioPerfil
 *
 * @ORM\Table(name="rl_usuario_perfil")
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
     * @ORM\OneToOne(targetEntity="TbPerfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     * })
     */
    private $idPerfil;

    /**
     * @var \TbUsuario
     *
     * @ORM\OneToOne(targetEntity="TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    protected $idUsuario;

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return \Base\BaseBundle\Entity\TbUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario ? $this->idUsuario : new TbUsuario();
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
        return $this->idPerfil ? $this->idPerfil : new TbPerfil();
    }

    /**
     * @param \TbPerfil $idPerfil
     */
    public function setIdPerfil($idPerfil)
    {
        $this->idPerfil = $idPerfil;
    }
}