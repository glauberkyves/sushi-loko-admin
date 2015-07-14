<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquiaOperador
 *
 * @ORM\Table(name="tb_franquia_operador", indexes={@ORM\Index(name="id_franquia", columns={"id_franquia"}), @ORM\Index(name="id_operador", columns={"id_operador"})})
 * @ORM\Entity
 */
class TbFranquiaOperador extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franquia_operador", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranquiaOperador;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbFranquia
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFranquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franquia", referencedColumnName="id_franquia")
     * })
     */
    private $idFranquia;

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
    public function getIdFranquiaOperador()
    {
        return $this->idFranquiaOperador;
    }

    /**
     * @param int $idFranquiaOperador
     */
    public function setIdFranquiaOperador($idFranquiaOperador)
    {
        $this->idFranquiaOperador = $idFranquiaOperador;
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
     * @return \TbFranquia
     */
    public function getIdFranquia()
    {
        return $this->idFranquia;
    }

    /**
     * @param \TbFranquia $idFranquia
     */
    public function setIdFranquia($idFranquia)
    {
        $this->idFranquia = $idFranquia;
    }

    /**
     * @return \TbUsuario
     */
    public function getIdOperador()
    {
        return $this->idOperador;
    }

    /**
     * @param \TbUsuario $idOperador
     */
    public function setIdOperador($idOperador)
    {
        $this->idOperador = $idOperador;
    }
}