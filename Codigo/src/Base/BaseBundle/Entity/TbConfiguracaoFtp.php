<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbConfiguracaoFtp
 *
 * @ORM\Table(name="tb_configuracao_ftp", indexes={@ORM\Index(name="fk_configuracaoftp_franqueador_idx", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbConfiguracaoFtp extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_configuracao_ftp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idConfiguracaoFtp;

    /**
     * @var string
     *
     * @ORM\Column(name="no_host", type="string", length=100, nullable=false)
     */
    private $noHost;

    /**
     * @var string
     *
     * @ORM\Column(name="no_usuario", type="string", length=100, nullable=false)
     */
    private $noUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="no_senha", type="string", length=100, nullable=false)
     */
    private $noSenha;

    /**
     * @var string
     *
     * @ORM\Column(name="no_pasta", type="string", length=500, nullable=false)
     */
    private $noPasta;

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
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;

    /**
     * @param int $idConfiguracaoFtp
     */
    public function setIdConfiguracaoFtp($idConfiguracaoFtp)
    {
        $this->idConfiguracaoFtp = $idConfiguracaoFtp;
    }

    /**
     * @return int
     */
    public function getIdFranqueador()
    {
        return $this->idFranqueador;
    }

    /**
     * @param int $idFranqueador
     */
    public function setIdFranqueador($idFranqueador)
    {
        $this->idFranqueador = $idFranqueador;
    }

    /**
     * @return string
     */
    public function getNoHost()
    {
        return $this->noHost;
    }

    /**
     * @param string $noHost
     */
    public function setNoHost($noHost)
    {
        $this->noHost = $noHost;
    }

    /**
     * @return string
     */
    public function getNoUsuario()
    {
        return $this->noUsuario;
    }

    /**
     * @param string $noUsuario
     */
    public function setNoUsuario($noUsuario)
    {
        $this->noUsuario = $noUsuario;
    }

    /**
     * @return string
     */
    public function getNoSenha()
    {
        return $this->noSenha;
    }

    /**
     * @param string $noSenha
     */
    public function setNoSenha($noSenha)
    {
        $this->noSenha = $noSenha;
    }

    /**
     * @return string
     */
    public function getNoPasta()
    {
        return $this->noPasta;
    }

    /**
     * @param string $noPasta
     */
    public function setNoPasta($noPasta)
    {
        $this->noPasta = $noPasta;
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
     * @return int
     */
    public function getIdConfiguracaoFtp()
    {
        return $this->idConfiguracaoFtp;
    }

}

