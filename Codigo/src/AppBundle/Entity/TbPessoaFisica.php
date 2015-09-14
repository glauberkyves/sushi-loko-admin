<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbPessoaFisica
 *
 * @ORM\Table(name="tb_pessoa_fisica", indexes={@ORM\Index(name="FK_PESSOAFISICA_PESSOA_idx", columns={"id_pessoa"})})
 * @ORM\Entity
 */
class TbPessoaFisica
{
    /**
     * @var string
     *
     * @ORM\Column(name="nu_cpf", type="string", length=11, nullable=true)
     */
    private $nuCpf;

    /**
     * @var string
     *
     * @ORM\Column(name="no_email", type="string", length=100, nullable=true)
     */
    private $noEmail;

    /**
     * @var \DateTime
     *
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
     * @ORM\Column(name="nu_telefone", type="string", length=20, nullable=true)
     */
    private $nuTelefone;

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

