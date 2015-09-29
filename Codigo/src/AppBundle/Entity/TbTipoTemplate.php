<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTipoTemplate
 *
 * @ORM\Table(name="tb_tipo_template")
 * @ORM\Entity
 */
class TbTipoTemplate
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


}

