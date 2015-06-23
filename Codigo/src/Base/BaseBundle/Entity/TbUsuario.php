<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbUsuario
 *
 * @ORM\Table(name="tb_usuario", indexes={@ORM\Index(name="FK_USUARIO_PESSAO_idx", columns={"id_pessoa"})})
 * @ORM\Entity
 */
class TbUsuario
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
     * @ORM\Column(name="nu_cpf", type="string", length=11, nullable=false)
     */
    private $nuCpf;

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
     * @ORM\ManyToOne(targetEntity="TbPessoa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pessoa", referencedColumnName="id_pessoa")
     * })
     */
    private $idPessoa;


}

