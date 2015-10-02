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
     * @ORM\Column(name="no_tipo_template", type="string", length=45, nullable=false)
     */
    private $noTipoTemplate;

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
    public function getNoTipoTemplate()
    {
        return $this->noTipoTemplate;
    }

    /**
     * @param string $noTipoTemplatecol
     */
    public function setNoTipoTemplate($noTipoTemplatecol)
    {
        $this->noTipoTemplate = $noTipoTemplatecol;
    }

}

