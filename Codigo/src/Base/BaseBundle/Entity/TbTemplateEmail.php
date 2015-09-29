<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTemplateEmail
 *
 * @ORM\Table(name="tb_template_email", indexes={@ORM\Index(name="fk_templateemail_franqueador_idx", columns={"id_franqueador"}), @ORM\Index(name="fk_templateemail_tipotemplate_idx", columns={"id_tipo_template"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\TemplateRepository")
 */
class TbTemplateEmail extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_template_email", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTemplateEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="no_url_logo", type="string", length=100, nullable=false)
     */
    private $noUrlLogo;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_template", type="text", length=65535, nullable=false)
     */
    private $dsTemplate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;

    /**
     * @var \TbTipoTemplate
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbTipoTemplate")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_template", referencedColumnName="id_tipo_template")
     * })
     */
    private $idTipoTemplate;

    /**
     * @return int
     */
    public function getIdTemplateEmail()
    {
        return $this->idTemplateEmail;
    }

    /**
     * @param int $idTemplateEmail
     */
    public function setIdTemplateEmail($idTemplateEmail)
    {
        $this->idTemplateEmail = $idTemplateEmail;
    }

    /**
     * @return string
     */
    public function getNoUrlLogo()
    {
        return $this->noUrlLogo;
    }

    /**
     * @param string $noUrlLogo
     */
    public function setNoUrlLogo($noUrlLogo)
    {
        $this->noUrlLogo = $noUrlLogo;
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
     * @return int
     */
    public function getStAtivo()
    {
        return $this->stAtivo;
    }

    /**
     * @param int $stAtivo
     */
    public function setStAtivo($stAtivo)
    {
        $this->stAtivo = $stAtivo;
    }

    /**
     * @return \TbFranqueador
     */
    public function getIdFranqueador()
    {
        return $this->idFranqueador;
    }

    /**
     * @param \TbFranqueador $idFranqueador
     */
    public function setIdFranqueador($idFranqueador)
    {
        $this->idFranqueador = $idFranqueador;
    }

    /**
     * @return \TbTipoTemplate
     */
    public function getIdTipoTemplate()
    {
        return $this->idTipoTemplate ? $this->idTipoTemplate : new TbTipoTemplate();
    }

    /**
     * @param \TbTipoTemplate $idTipoTemplate
     */
    public function setIdTipoTemplate($idTipoTemplate)
    {
        $this->idTipoTemplate = $idTipoTemplate;
    }

    /**
     * @return string
     */
    public function getDsTemplate()
    {
        return $this->dsTemplate;
    }

    /**
     * @param string $dsTemplate
     */
    public function setDsTemplate($dsTemplate)
    {
        $this->dsTemplate = $dsTemplate;
    }

}

