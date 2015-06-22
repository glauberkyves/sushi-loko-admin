<?php

namespace Base\BaseBundle\Entity;

use Base\BaseBundle\Entity\AbstractEntity;
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
     * @ORM\Column(name="nu_cnpj", type="integer", nullable=false)
     */
    private $nuCnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="no_fantansia", type="string", length=100, nullable=true)
     */
    private $noFantansia;

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
     * Set nuCnpj
     *
     * @param integer $nuCnpj
     * @return TbPessoaJuridica
     */
    public function setNuCnpj($nuCnpj)
    {
        $this->nuCnpj = $nuCnpj;

        return $this;
    }

    /**
     * Get nuCnpj
     *
     * @return integer
     */
    public function getNuCnpj()
    {
        return $this->nuCnpj;
    }

    /**
     * Set noFantansia
     *
     * @param string $noFantansia
     * @return TbPessoaJuridica
     */
    public function setNoFantansia($noFantansia)
    {
        $this->noFantansia = $noFantansia;

        return $this;
    }

    /**
     * Get noFantansia
     *
     * @return string
     */
    public function getNoFantansia()
    {
        return $this->noFantansia;
    }

    /**
     * Set idPessoa
     *
     * @param \Base\BaseBundle\Entity\TbPessoa $idPessoa
     * @return TbPessoaJuridica
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
}
