<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Base\BaseBundle\Validator\Constraints as BaseAssert;

/**
 * TbPessoaFisica
 *
 * @ORM\Table(name="tb_pessoa_fisica", indexes={@ORM\Index(name="FK_PESSOAFISICA_PESSOA_idx", columns={"id_pessoa"})})
 * @ORM\Entity
 */
class TbPessoaFisica extends AbstractEntity
{
    /**
     * @var integer
     *
     * @BaseAssert\ConstraintCPF(message="base_bundle.validators.cpf")
     * @ORM\Column(name="nu_cpf", type="string", nullable=true)
     */
    private $nuCpf;

    /**
     * @var \DateTime
     *
     * @Assert\DateTime(message="base_bundle.validators.datetime")
     * @ORM\Column(name="dt_nascimento", type="datetime", nullable=true)
     */
    private $dtNascimento;

    /**
     * @var string
     *
     * @ORM\Column(name="sg_sexo", type="string", length=1, nullable=true)
     */
    private $sgSexo;

    /**
     * @var string
     *
     * @ORM\Column(name="creci", type="string",  nullable=true)
     */
    private $creci;

    /**
     * @var \TbPessoa
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbPessoa", inversedBy="idPessoaFisica")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pessoa", referencedColumnName="id_pessoa")
     * })
     */
    private $idPessoa;

    /**
     * Set noSobrenome
     *
     * @param string $noSobrenome
     * @return TbPessoaFisica
     */
    public function setNoSobrenome($noSobrenome)
    {
        $this->noSobrenome = $noSobrenome;

        return $this;
    }

    /**
     * Get noSobrenome
     *
     * @return string
     */
    public function getNoSobrenome()
    {
        return $this->noSobrenome;
    }

    /**
     * Set nuCpf
     *
     * @param integer $nuCpf
     * @return TbPessoaFisica
     */
    public function setNuCpf($nuCpf)
    {
        $this->nuCpf = $nuCpf;

        return $this;
    }

    /**
     * Get nuCpf
     *
     * @return integer
     */
    public function getNuCpf()
    {
        return $this->nuCpf;
    }

    /**
     * Set dtNascimento
     *
     * @param \DateTime $dtNascimento
     * @return TbPessoaFisica
     */
    public function setDtNascimento($dtNascimento)
    {
        $this->dtNascimento = $dtNascimento;

        return $this;
    }

    /**
     * Get dtNascimento
     *
     * @return \DateTime
     */
    public function getDtNascimento()
    {
        return $this->dtNascimento;
    }

    /**
     * Set sgSexo
     *
     * @param string $sgSexo
     * @return TbPessoaFisica
     */
    public function setSgSexo($sgSexo)
    {
        $this->sgSexo = $sgSexo;

        return $this;
    }

    /**
     * Get sgSexo
     *
     * @return string
     */
    public function getSgSexo()
    {
        return $this->sgSexo;
    }

    /**
     * Set idPessoa
     *
     * @param \Base\BaseBundle\Entity\TbPessoa $idPessoa
     * @return TbPessoaFisica
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
        return $this->idPessoa;
    }

    /**
     * @return string
     */
    public function getCreci()
    {
        return $this->creci;
    }

    /**
     * @param string $creci
     */
    public function setCreci($creci)
    {
        $this->creci = $creci;
    }
}
