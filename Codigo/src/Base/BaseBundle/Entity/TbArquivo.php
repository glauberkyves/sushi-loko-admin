<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbArquivo
 *
 * @ORM\Table(name="tb_arquivo")
 * @ORM\Entity
 */
class TbArquivo extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_arquivo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArquivo;

    /**
     * @var string
     *
     * @ORM\Column(name="no_arquivo", type="string", length=100, nullable=false)
     */
    private $noArquivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_processamento", type="datetime", nullable=false)
     */
    private $dtProcessamento;

    /**
     * @var string
     *
     * @ORM\Column(name="no_blob_arquivo", type="blob", length=65535, nullable=false)
     */
    private $noBlobArquivo;

    /**
     * @param int $idArquivo
     */
    public function setIdArquivo($idArquivo)
    {
        $this->idArquivo = $idArquivo;
    }

    /**
     * @return string
     */
    public function getNoArquivo()
    {
        return $this->noArquivo;
    }

    /**
     * @param string $noArquivo
     */
    public function setNoArquivo($noArquivo)
    {
        $this->noArquivo = $noArquivo;
    }

    /**
     * @return \DateTime
     */
    public function getDtProcessamento()
    {
        return $this->dtProcessamento;
    }

    /**
     * @param \DateTime $dtProcessamento
     */
    public function setDtProcessamento($dtProcessamento)
    {
        $this->dtProcessamento = $dtProcessamento;
    }

    /**
     * @return string
     */
    public function getNoBlobArquivo()
    {
        return $this->noBlobArquivo;
    }

    /**
     * @param string $noBlobArquivo
     */
    public function setNoBlobArquivo($noBlobArquivo)
    {
        $this->noBlobArquivo = $noBlobArquivo;
    }


}

