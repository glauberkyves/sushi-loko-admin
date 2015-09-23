<?php
namespace Base\BaseBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * TbUsuario
 *
 * @ORM\Table(name="tb_usuario", indexes={@ORM\Index(name="FK_USUARIO_PESSAO_idx", columns={"id_pessoa"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\UsuarioRepository")
 */
class TbUsuario extends AbstractEntity implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsuario;
    /**
     * @var string
     *
     * @ORM\Column(name="no_senha", type="string", length=32, nullable=false)
     */
    private $noSenha;
    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo = '0';
    /**
     * @var string
     *
     * @ORM\Column(name="no_latitude", type="string", length=32, nullable=false)
     */
    private $noLatitude;
    /**
     * @var string
     *
     * @ORM\Column(name="no_longitude", type="string", length=32, nullable=false)
     */
    private $noLongitude;
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
     * @var \TbPessoa
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbPessoa", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pessoa", referencedColumnName="id_pessoa")
     * })
     */
    private $idPessoa;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\RlUsuarioPerfil", mappedBy="idUsuario")
     */
    private $rlUsuarioPerfil;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueadorUsuario", mappedBy="idUsuario")
     */
    private $idFranqueadorUsuario;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbFranquiaOperador", mappedBy="idOperador")
     */
    private $idFranquiaOperador;
    /**
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueador", mappedBy="idUsuario")
     */
    private $idFranqueador;
    /**
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbFranquia", mappedBy="idUsuario")
     */
    private $idFranquia;
    /**
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueadorOperador", mappedBy="idOperador")
     */
    private $idOperadorFranqueador;
    /**
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbFranquiaOperador", mappedBy="idOperador")
     */
    private $idOperadorFranquia;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Base\BaseBundle\Entity\TbTransacao", mappedBy="idUsuario")
     */
    private $idTransacao;

    private $salt;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rlUsuarioPerfil = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salt            = md5(uniqid(null, true));

    }
    /**
     * @param int $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }
    /**
     * Get idUsuario
     *
     * @return integer
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
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
     * Set noSenha
     *
     * @param string $noSenha
     * @return TbUsuario
     */
    public function setNoSenha($noSenha)
    {
        $this->noSenha = $noSenha;
        return $this;
    }
    /**
     * Get noSenha
     *
     * @return string
     */
    public function getNoSenha()
    {
        return $this->noSenha;
    }
    /**
     * Set stAtivo
     *
     * @param integer $stAtivo
     * @return TbUsuario
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
     * @return TbUsuario
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
     * @return TbUsuario
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
     * Set idPessoa
     *
     * @param \Base\BaseBundle\TbPessoa $idPessoa
     * @return TbUsuario
     */
    public function setIdPessoa(\Base\BaseBundle\Entity\TbPessoa $idPessoa)
    {
        $this->idPessoa = $idPessoa;
        return $this;
    }
    /**
     * Get idPessoa
     *
     * @return \Base\BaseBundle\Entity\TbPessoa
     */
    public function getIdPessoa()
    {
        return $this->idPessoa ? $this->idPessoa : new TbPessoa();
    }
    /**
     * Get rlUsuarioPerfil
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRlUsuarioPerfil()
    {
        return $this->rlUsuarioPerfil;
    }
    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdFranqueadorUsuario()
    {
        return $this->idFranqueadorUsuario;
    }
    /**
     * @param \Doctrine\Common\Collections\Collection $idFranqueadorUsuario
     */
    public function setIdFranqueadorUsuario($idFranqueadorUsuario)
    {
        $this->idFranqueadorUsuario = $idFranqueadorUsuario;
    }
    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        $arrRoles = array();
        foreach ($this->getRlUsuarioPerfil() as $rlUsuarioPerfil) {
            array_push($arrRoles, $rlUsuarioPerfil->getIdPerfil()->getSgPerfil());
        }
        return $arrRoles;
    }
    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->noSenha;
    }
    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }
    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }
    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getIdPessoa()->getNoPessoa(true);
    }
    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        /*
         * ! Don't serialize $roles field !
         */
        return \serialize(array(
            $this->idUsuario,
            $this->dtCadastro,
            $this->dtAtualizacao,
            $this->noSenha,
            $this->stAtivo,
            $this->salt,
            serialize($this->getRoles()),
        ));
    }
    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->idUsuario,
            $this->dtCadastro,
            $this->dtAtualizacao,
            $this->noSenha,
            $this->stAtivo,
            $this->salt,
            $roles,
            ) = \unserialize($serialized);
        $this->roles = unserialize($roles);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdFranquiaOperador()
    {
        return $this->idFranquiaOperador;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idFranquiaOperador
     */
    public function setIdFranquiaOperador($idFranquiaOperador)
    {
        $this->idFranquiaOperador = $idFranquiaOperador;
    }

    /**
     * @return mixed
     */
    public function getIdFranquia()
    {
        return $this->idFranquia;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $rlUsuarioPerfil
     */
    public function setRlUsuarioPerfil($rlUsuarioPerfil)
    {
        $this->rlUsuarioPerfil = $rlUsuarioPerfil;
    }

    /**
     * @param mixed $idFranquia
     */
    public function setIdFranquia($idFranquia)
    {
        $this->idFranquia = $idFranquia;
    }

    /**
     * @return string
     */
    public function getNoLatitude()
    {
        return $this->noLatitude;
    }

    /**
     * @param string $noLatitude
     */
    public function setNoLatitude($noLatitude)
    {
        $this->noLatitude = $noLatitude;
    }

    /**
     * @return string
     */
    public function getNoLongitude()
    {
        return $this->noLongitude;
    }

    /**
     * @param string $noLongitude
     */
    public function setNoLongitude($noLongitude)
    {
        $this->noLongitude = $noLongitude;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdTransacao()
    {
        return $this->idTransacao;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idTransacao
     */
    public function setIdTransacao($idTransacao)
    {
        $this->idTransacao = $idTransacao;
    }

    /**
     * @return mixed
     */
    public function getIdOperadorFranqueador()
    {
        return $this->idOperadorFranqueador;
    }

    /**
     * @param mixed $idOperadorFranqueador
     */
    public function setIdOperadorFranqueador($idOperadorFranqueador)
    {
        $this->idOperadorFranqueador = $idOperadorFranqueador;
    }

    /**
     * @return mixed
     */
    public function getIdOperadorFranquia()
    {
        return $this->idOperadorFranquia;
    }

    /**
     * @param mixed $idOperadorFranquia
     */
    public function setIdOperadorFranquia($idOperadorFranquia)
    {
        $this->idOperadorFranquia = $idOperadorFranquia;
    }


}
