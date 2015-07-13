<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbPessoaJuridica
 *
 * @ORM\Table(name="tb_pessoa_juridica", indexes={@ORM\Index(name="FK_PESSOAJURIDICA_PESSOA_idx", columns={"id_pessoa"})})
 * @ORM\Entity
 */
class TbPessoaJuridica extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="nu_cnpj", type="string", length=14, nullable=true)
     */
    private $nuCnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="no_fantasia", type="string", length=100, nullable=true)
     */
    private $noFantasia;

    /**
     * @var string
     *
     * @ORM\Column(name="no_razao_social", type="string", length=100, nullable=true)
     */
    private $noRazaoSocial;

    /**
     * @var \TbPessoa
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbPessoa", inversedBy="idPessoaJuridica")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pessoa", referencedColumnName="id_pessoa")
     * })
     */
    private $idPessoa;

    /**
     * @return int
     */
    public function getNuCnpj()
    {
        return $this->nuCnpj;
    }

    /**
     * @param int $nuCnpj
     */
    public function setNuCnpj($nuCnpj)
    {
        $this->nuCnpj = $nuCnpj;
    }

    /**
     * @return string
     */
    public function getNoFantasia()
    {
        return $this->noFantasia;
    }

    /**
     * @param string $noFantasia
     */
    public function setNoFantasia($noFantasia)
    {
        $this->noFantasia = $noFantasia;
    }

    /**
     * @return \TbPessoa
     */
    public function getIdPessoa()
    {
        return $this->idPessoa;
    }

    /**
     * @param \TbPessoa $idPessoa
     */
    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * @return string
     */
    public function getNoRazaoSocial()
    {
        return $this->noRazaoSocial;
    }

    /**
     * @param string $noRazaoSocial
     */
    public function setNoRazaoSocial($noRazaoSocial)
    {
        $this->noRazaoSocial = $noRazaoSocial;
    }
}

