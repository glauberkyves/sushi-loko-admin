<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEmailError
 *
 * @ORM\Table(name="tb_email_error")
 * @ORM\Entity
 */
class TbEmailError
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_email_error", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEmailError;

    /**
     * @var string
     *
     * @ORM\Column(name="no_destinatario", type="string", length=100, nullable=false)
     */
    private $noDestinatario;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_assunto", type="string", length=250, nullable=false)
     */
    private $dsAssunto;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_mensagem", type="text", length=65535, nullable=false)
     */
    private $dsMensagem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_envio", type="datetime", nullable=true)
     */
    private $dtEnvio;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_envio", type="integer", nullable=false)
     */
    private $stEnvio;


}

