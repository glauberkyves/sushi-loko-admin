<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFaq
 *
 * @ORM\Table(name="tb_faq")
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\FaqRepository")
 */
class TbFaq extends AbstractEntity
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

    /**
     * @return int
     */
    public function getIdFaq()
    {
        return $this->idFaq;
    }

    /**
     * @param int $idFaq
     */
    public function setIdFaq($idFaq)
    {
        $this->idFaq = $idFaq;
    }

    /**
     * @return string
     */
    public function getNoAssunto()
    {
        return $this->noAssunto;
    }

    /**
     * @param string $noAssunto
     */
    public function setNoAssunto($noAssunto)
    {
        $this->noAssunto = $noAssunto;
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
     * @return string
     */
    public function getNoDescricao()
    {
        return $this->noDescricao;
    }

    /**
     * @param string $noDescricao
     */
    public function setNoDescricao($noDescricao)
    {
        $this->noDescricao = $noDescricao;
    }



}

