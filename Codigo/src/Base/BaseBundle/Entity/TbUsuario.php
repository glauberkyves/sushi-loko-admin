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
}