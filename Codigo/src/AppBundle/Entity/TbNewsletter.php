<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbNewsletter
 *
 * @ORM\Table(name="tb_newsletter")
 * @ORM\Entity
 */
class TbNewsletter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_news", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNews;

    /**
     * @var string
     *
     * @ORM\Column(name="no_nome", type="string", length=100, nullable=false)
     */
    private $noNome;

    /**
     * @var string
     *
     * @ORM\Column(name="no_email", type="string", length=100, nullable=false)
     */
    private $noEmail;

    /**
     * @var int
     *
     * @ORM\Column(name="nu_telefone", type="integer", nullable=true)
     */
    private $nuTelefone;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_como_conheceu", type="string", length=100, nullable=true)
     */
    private $dsComoConheceu;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_mensagem", type="text", length=65535, nullable=true)
     */
    private $dsMensagem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;


}

