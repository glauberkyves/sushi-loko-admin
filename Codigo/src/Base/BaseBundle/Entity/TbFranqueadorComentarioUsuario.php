<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueadorComentarioUsuario
 *
 * @ORM\Table(name="tb_franqueador_comentario_usuario", indexes={@ORM\Index(name="fk_franqueadorcomentariousuario_franqueadousuario_idx", columns={"id_franqueador_usuario"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\FranqueadorComentarioUsuarioRepository")
 */
class TbFranqueadorComentarioUsuario extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franqueador_comentario_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranqueadorComentarioUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="ds_comentario", type="text", length=65535, nullable=false)
     */
    private $dsComentario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbFranqueadorUsuario
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbFranqueadorUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador_usuario", referencedColumnName="id_franqueador_usuario")
     * })
     */
    private $idFranqueadorUsuario;

    /**
     * @return int
     */
    public function getIdFranqueadorComentarioUsuario()
    {
        return $this->idFranqueadorComentarioUsuario;
    }

    /**
     * @param int $idFranqueadorComentarioUsuario
     */
    public function setIdFranqueadorComentarioUsuario($idFranqueadorComentarioUsuario)
    {
        $this->idFranqueadorComentarioUsuario = $idFranqueadorComentarioUsuario;
    }

    /**
     * @return string
     */
    public function getDsComentario()
    {
        return $this->dsComentario;
    }

    /**
     * @param string $dsComentario
     */
    public function setDsComentario($dsComentario)
    {
        $this->dsComentario = $dsComentario;
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
     * @return \TbFranqueadorUsuario
     */
    public function getIdFranqueadorUsuario()
    {
        return $this->idFranqueadorUsuario;
    }

    /**
     * @param \TbFranqueadorUsuario $idFranqueadorUsuario
     */
    public function setIdFranqueadorUsuario($idFranqueadorUsuario)
    {
        $this->idFranqueadorUsuario = $idFranqueadorUsuario;
    }
}

