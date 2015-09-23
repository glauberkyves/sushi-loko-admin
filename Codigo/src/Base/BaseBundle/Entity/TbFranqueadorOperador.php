<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueadorOperador
 *
 * @ORM\Table(name="tb_franqueador_operador", indexes={@ORM\Index(name="fk_franqueadoroperador_franqueador_idx", columns={"id_franqueador"}), @ORM\Index(name="fk_franqueadoroperador_operador_idx", columns={"id_operador"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\FranqueadorOperadorRepository")
 */
class TbFranqueadorOperador extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franqueador_operador", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranqueadorOperador;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var Int
     *
     * @ORM\Column(name="st_visualizacao", type="integer", nullable=false)
     */
    private $stVisualizacao;

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
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_operador", referencedColumnName="id_usuario")
     * })
     */
    private $idOperador;

    /**
     * @return int
     */
    public function getIdFranqueadorOperador()
    {
        return $this->idFranqueadorOperador;
    }

    /**
     * @param int $idFranqueadorOperador
     */
    public function setIdFranqueadorOperador($idFranqueadorOperador)
    {
        $this->idFranqueadorOperador = $idFranqueadorOperador;
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
     * @return \TbUsuario
     */
    public function getIdOperador()
    {
        return $this->idOperador ? $this->idOperador : new TbUsuario();
    }

    /**
     * @param \TbUsuario $idOperador
     */
    public function setIdOperador($idOperador)
    {
        $this->idOperador = $idOperador;
    }

    /**
     * @return Int
     */
    public function getStVisualizacao()
    {
        return $this->stVisualizacao;
    }

    /**
     * @param Int $stVisualizacao
     */
    public function setStVisualizacao($stVisualizacao)
    {
        $this->stVisualizacao = $stVisualizacao;
    }


}

