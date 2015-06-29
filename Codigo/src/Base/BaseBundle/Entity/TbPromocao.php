<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbPromocao
 *
 * @ORM\Table(name="tb_promocao")
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\PromocaoRepository")
 */
class TbPromocao extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_promocao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPromocao;

    /**
     * @var string
     *
     * @ORM\Column(name="no_promocao", type="string", length=100, nullable=false)
     */
    private $noPromocao;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_promocao", type="text", length=65535, nullable=false)
     */
    private $dsPromocao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_validade", type="datetime", nullable=false)
     */
    private $dtValidade;

    /**
     * @var string
     *
     * @ORM\Column(name="no_imagem", type="string", length=100, nullable=true)
     */
    private $noImagem;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @return int
     */
    public function getIdPromocao()
    {
        return $this->idPromocao;
    }

    /**
     * @param int $idPromocao
     */
    public function setIdPromocao($idPromocao)
    {
        $this->idPromocao = $idPromocao;
    }

    /**
     * @return string
     */
    public function getNoPromocao()
    {
        return $this->noPromocao;
    }

    /**
     * @param string $noPromocao
     */
    public function setNoPromocao($noPromocao)
    {
        $this->noPromocao = $noPromocao;
    }

    /**
     * @return string
     */
    public function getDsPromocao()
    {
        return $this->dsPromocao;
    }

    /**
     * @param string $dsPromocao
     */
    public function setDsPromocao($dsPromocao)
    {
        $this->dsPromocao = $dsPromocao;
    }

    /**
     * @return \DateTime
     */
    public function getDtValidade()
    {
        return $this->dtValidade;
    }

    /**
     * @param \DateTime $dtValidade
     */
    public function setDtValidade($dtValidade)
    {
        $this->dtValidade = $dtValidade;
    }

    /**
     * @return string
     */
    public function getNoImagem()
    {
        return $this->noImagem;
    }

    /**
     * @param string $noImagem
     */
    public function setNoImagem($noImagem)
    {
        $this->noImagem = $noImagem;
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


}

