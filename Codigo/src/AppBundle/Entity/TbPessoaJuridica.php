<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbPessoaJuridica
 *
 * @ORM\Table(name="tb_pessoa_juridica", indexes={@ORM\Index(name="FK_PESSOAJURIDICA_PESSOA_idx", columns={"id_pessoa"})})
 * @ORM\Entity
 */
class TbPessoaJuridica
{
    /**
     * @var string
     *
     * @ORM\Column(name="nu_cnpj", type="string", length=14, nullable=false)
     */
    private $nuCnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="no_fantasia", type="string", length=100, nullable=true)
     */
    private $noFantasia;

    /**
     * @var \TbPessoa
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="TbPessoa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pessoa", referencedColumnName="id_pessoa")
     * })
     */
    private $idPessoa;


}

