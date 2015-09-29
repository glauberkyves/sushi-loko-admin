<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTipoTemplate
 *
 * @ORM\Table(name="tb_tipo_template")
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\TipoTemplateRepository")
 */
class TbTipoTemplate extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_template", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTipoTemplate;

    /**
     * @var string
     *
     * @ORM\Column(name="no_tipo_templatecol", type="string", length=45, nullable=false)
     */
    private $noTipoTemplatecol;

    /**
     * @return int
     */
    public function getIdTipoTemplate()
    {
        return $this->idTipoTemplate;
    }

    /**
     * @param int $idTipoTemplate
     */
    public function setIdTipoTemplate($idTipoTemplate)
    {
        $this->idTipoTemplate = $idTipoTemplate;
    }

    /**
     * @return string
     */
    public function getNoTipoTemplatecol()
    {
        return $this->noTipoTemplatecol;
    }

    /**
     * @param string $noTipoTemplatecol
     */
    public function setNoTipoTemplatecol($noTipoTemplatecol)
    {
        $this->noTipoTemplatecol = $noTipoTemplatecol;
    }

}

