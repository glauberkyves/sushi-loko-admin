<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TbPessoa
 *
 * @ORM\Table(name="tb_pessoa")
 * @ORM\Entity
 */
class TbPessoa extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_pessoa", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPessoa;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="usuario_bundle.validators.pessoa_fisica.noPessoa.notBlank")
     * @ORM\Column(name="no_pessoa", type="string", length=100, nullable=false)
     */
    private $noPessoa;

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
     * @var TbPessoaFisica
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbPessoaFisica", mappedBy="idPessoa")
     */
    protected $idPessoaFisica;

    /**
     * @var TbPessoaJuridica
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbPessoaJuridica", mappedBy="idPessoa")
     */
    protected $idPessoaJuridica;

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
     * @var \TbUsuario
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbUsuario", mappedBy="idPessoa")
     */
    private $idUsuario;

    /**
     * @param int $idPessoa
     */
    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * Get idPessoa
     *
     * @return integer
     */
    public function getIdPessoa()
    {
        return $this->idPessoa;
    }

    /**
     * Set noPessoa
     *
     * @param string $noPessoa
     * @return TbPessoaFisica
     */
    public function setNoPessoa($noPessoa)
    {
        $this->noPessoa = $noPessoa;

        return $this;
    }

    /**
     * Get noPessoa
     *
     * @return string
     */
    public function getNoPessoa($firstName = false)
    {
        if ($firstName) {
            return substr($this->noPessoa, 0, strpos($this->noPessoa, ' ')) ?: $this->noPessoa;
        }

        return $this->noPessoa;
    }

    /**
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return TbPessoa
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
     * @return TbPessoa
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
     * @return \Base\BaseBundle\Entity\TbPessoaFisica
     */
    public function getIdPessoaFisica()
    {
        return $this->idPessoaFisica ? $this->idPessoaFisica : new TbPessoaFisica();
    }

    /**
     * @return \Base\BaseBundle\Entity\TbPessoaJuridica
     */
    public function getIdPessoaJuridica()
    {
        return $this->idPessoaJuridica ? $this->idPessoaJuridica : new TbPessoaJuridica();
    }

    /**
     * @return TbPessoa
     */
    public function setIdPessoaFisica(\Base\BaseBundle\Entity\TbPessoaFisica $idPessoaFisica)
    {
        $this->idPessoaFisica = $idPessoaFisica;

        return $this;
    }

    /**
     * @return TbPessoa
     */
    public function setIdPessoaJuridica(\Base\BaseBundle\Entity\TbPessoaJuridica $idPessoaJuridica)
    {
        $this->idPessoaJuridica = $idPessoaJuridica;

        return $this;
    }

    /**
     * @return string
     */
    public function getNoEmail()
    {
        return $this->noEmail;
    }

    /**
     * @param string $noEmail
     */
    public function setNoEmail($noEmail)
    {
        $this->noEmail = $noEmail;
    }

}
