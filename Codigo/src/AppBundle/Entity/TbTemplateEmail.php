<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTemplateEmail
 *
 * @ORM\Table(name="tb_template_email", indexes={@ORM\Index(name="fk_templateemail_franqueador_idx", columns={"id_franqueador"}), @ORM\Index(name="fk_templateemail_tipotemplate_idx", columns={"id_tipo_template"})})
 * @ORM\Entity
 */
class TbTemplateEmail
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
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;

    /**
     * @var \TbTipoTemplate
     *
     * @ORM\ManyToOne(targetEntity="TbTipoTemplate")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_template", referencedColumnName="id_tipo_template")
     * })
     */
    private $idTipoTemplate;


}

