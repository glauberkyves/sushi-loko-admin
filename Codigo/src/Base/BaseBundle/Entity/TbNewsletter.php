<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TbNewsletter
 *
 * @ORM\Table(name="tb_newsletter")
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\NewsletterRepository")
 */
class TbNewsletter extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_news", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNews;

    /**
     * @var string
     * @Assert\NotBlank(message="base_bundle.validators.fale_conosco.noNome.notBlank")
     * @ORM\Column(name="no_nome", type="string", length=100, nullable=false)
     */
    private $noNome;

    /**
     * @var string
     * @Assert\NotBlank(message="base_bundle.validators.fale_conosco.noEmail.notBlank")
     * * @Assert\Email(message = "base_bundle.validators.fale_conosco.noEmail.email")
     * @ORM\Column(name="no_email", type="string", length=100, nullable=false)
     */
    private $noEmail;

    /**
     * @var integer
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
     * @Assert\NotBlank(message="base_bundle.validators.fale_conosco.dsMensagem.notBlank")
     * @ORM\Column(name="ds_mensagem", type="text", length=65535, nullable=true)
     */
    private $dsMensagem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @param string $dsComoConheceu
     */
    public function setDsComoConheceu($dsComoConheceu)
    {
        $this->dsComoConheceu = $dsComoConheceu;
    }

    /**
     * @return string
     */
    public function getDsComoConheceu()
    {
        return $this->dsComoConheceu;
    }

    /**
     * @param string $dsMensagem
     */
    public function setDsMensagem($dsMensagem)
    {
        $this->dsMensagem = $dsMensagem;
    }

    /**
     * @return string
     */
    public function getDsMensagem()
    {
        return $this->dsMensagem;
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
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * @param string $noEmail
     */
    public function setNoEmail($noEmail)
    {
        $this->noEmail = $noEmail;
    }

    /**
     * @return string
     */
    public function getNoEmail()
    {
        return $this->noEmail;
    }

    /**
     * @param string $noNome
     */
    public function setNoNome($noNome)
    {
        $this->noNome = $noNome;
    }

    /**
     * @return string
     */
    public function getNoNome()
    {
        return $this->noNome;
    }

    /**
     * @param int $nuTelefone
     */
    public function setNuTelefone($nuTelefone)
    {
        $this->nuTelefone = $nuTelefone;
    }

    /**
     * @return int
     */
    public function getNuTelefone()
    {
        return $this->nuTelefone;
    }

    /**
     * @return int
     */
    public function getIdNews()
    {
        return $this->idNews;
    }
}