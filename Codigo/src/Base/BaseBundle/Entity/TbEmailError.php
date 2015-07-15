<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEmailError
 *
 * @ORM\Table(name="tb_email_error")
 * @ORM\Entity
 */
class TbEmailError extends AbstractEntity
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

    /**
     * @return int
     */
    public function getIdEmailError()
    {
        return $this->idEmailError;
    }

    /**
     * @param int $idEmailError
     */
    public function setIdEmailError($idEmailError)
    {
        $this->idEmailError = $idEmailError;
    }

    /**
     * @return string
     */
    public function getNoDestinatario()
    {
        return $this->noDestinatario;
    }

    /**
     * @param string $noDestinatario
     */
    public function setNoDestinatario($noDestinatario)
    {
        $this->noDestinatario = $noDestinatario;
    }

    /**
     * @return string
     */
    public function getDsAssunto()
    {
        return $this->dsAssunto;
    }

    /**
     * @param string $dsAssunto
     */
    public function setDsAssunto($dsAssunto)
    {
        $this->dsAssunto = $dsAssunto;
    }

    /**
     * @return string
     */
    public function getDsMensagem()
    {
        return $this->dsMensagem;
    }

    /**
     * @param string $dsMensagem
     */
    public function setDsMensagem($dsMensagem)
    {
        $this->dsMensagem = $dsMensagem;
    }

    /**
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * @param \DateTime $dtCadastro
     */
    public function setDtCadastro($dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
    }

    /**
     * @return \DateTime
     */
    public function getDtEnvio()
    {
        return $this->dtEnvio;
    }

    /**
     * @param \DateTime $dtEnvio
     */
    public function setDtEnvio($dtEnvio)
    {
        $this->dtEnvio = $dtEnvio;
    }

    /**
     * @return int
     */
    public function getStEnvio()
    {
        return $this->stEnvio;
    }

    /**
     * @param int $stEnvio
     */
    public function setStEnvio($stEnvio)
    {
        $this->stEnvio = $stEnvio;
    }
}

