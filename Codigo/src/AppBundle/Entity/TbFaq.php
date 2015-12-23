<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFaq
 *
 * @ORM\Table(name="tb_faq")
 * @ORM\Entity
 */
class TbFaq
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_faq", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFaq;

    /**
     * @var string
     *
     * @ORM\Column(name="no_assunto", type="string", length=250, nullable=false)
     */
    private $noAssunto;

    /**
     * @var int
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var string
     *
     * @ORM\Column(name="no_descricao", type="string", length=9000, nullable=false)
     */
    private $noDescricao;


}

