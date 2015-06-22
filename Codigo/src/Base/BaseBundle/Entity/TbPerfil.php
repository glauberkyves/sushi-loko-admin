<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TbPerfil
 *
 * @ORM\Table(name="tb_perfil")
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\PerfilRepository")
 */
class TbPerfil extends AbstractEntity implements RoleInterface, \Serializable
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
     * @Assert\NotBlank(message="super_usuario_bundle.validators.perfil.noPerfil.notBlank")
     * @ORM\Column(name="no_perfil", type="string", length=100, nullable=false)
     */
    private $noPerfil;

    /**
     * @var string
     * @Assert\NotBlank(message="super_usuario_bundle.validators.perfil.sgPerfil.notBlank")
     * @ORM\Column(name="sg_perfil", type="string", length=100, nullable=false)
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\RlUsuarioPerfil", mappedBy="idPerfil")
     */
    private $rlUsuarioPerfil;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rlUsuarioPerfil = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idPerfil
     *
     * @return integer
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }

    /**
     * Set noPerfil
     *
     * @param string $noPerfil
     * @return TbPerfil
     */
    public function setNoPerfil($noPerfil)
    {
        $this->noPerfil = $noPerfil;

        return $this;
    }

    /**
     * Get noPerfil
     *
     * @return string
     */
    public function getNoPerfil()
    {
        return $this->noPerfil;
    }

    /**
     * Set stAtivo
     *
     * @param integer $stAtivo
     * @return TbPerfil
     */
    public function setStAtivo($stAtivo)
    {
        $this->stAtivo = $stAtivo;

        return $this;
    }

    /**
     * Get stAtivo
     *
     * @return integer
     */
    public function getStAtivo()
    {
        return $this->stAtivo;
    }

    /**
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return TbPerfil
     */
    public function setDtCadastro($dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;

        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * Set dtAtualizacao
     *
     * @param \DateTime $dtAtualizacao
     * @return TbPerfil
     */
    public function setDtAtualizacao($dtAtualizacao)
    {
        $this->dtAtualizacao = $dtAtualizacao;

        return $this;
    }

    /**
     * Get dtAtualizacao
     *
     * @return \DateTime
     */
    public function getDtAtualizacao()
    {
        return $this->dtAtualizacao;
    }

    /**
     * Get idUsuario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRlUsuarioPerfil()
    {
        return $this->rlUsuarioPerfil;
    }

    /**
     * @param string $sgPerfil
     */
    public function setSgPerfil($sgPerfil)
    {
        $this->sgPerfil = $sgPerfil;
    }

    /**
     * @return string
     */
    public function getSgPerfil()
    {
        return $this->sgPerfil;
    }

    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole()
    {
        return $this->sgPerfil;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        /*
         * ! Don't serialize $users field !
         */
        return \serialize(array(
            $this->idPerfil,
            $this->sgPerfil
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list(
            $this->idPerfil,
            $this->sgPerfil
            ) = \unserialize($serialized);
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->rlUsuarioPerfil = $idUsuario;
    }
}