<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEnqueteRespostaUsuario
 *
 * @ORM\Table(name="tb_enquete_resposta_usuario", indexes={@ORM\Index(name="id_enquete_resposta", columns={"id_enquete_resposta"}), @ORM\Index(name="id_usuario", columns={"id_usuario"})})
 * @ORM\Entity
 */
class TbEnqueteRespostaUsuario extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_enquete_resposta_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEnqueteRespostaUsuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var \TbEnqueteResposta
     *
     * @ORM\ManyToOne(targetEntity="TbEnqueteResposta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_enquete_resposta", referencedColumnName="id_resposta")
     * })
     */
    private $idEnqueteResposta;

    /**
     * @var \TbUsuario
     *
     * @ORM\ManyToOne(targetEntity="TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;

    /**
     * @return int
     */
    public function getIdEnqueteRespostaUsuario()
    {
        return $this->idEnqueteRespostaUsuario;
    }

    /**
     * @param int $idEnqueteRespostaUsuario
     */
    public function setIdEnqueteRespostaUsuario($idEnqueteRespostaUsuario)
    {
        $this->idEnqueteRespostaUsuario = $idEnqueteRespostaUsuario;
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
     * @return \TbEnqueteResposta
     */
    public function getIdEnqueteResposta()
    {
        return $this->idEnqueteResposta;
    }

    /**
     * @param \TbEnqueteResposta $idEnqueteResposta
     */
    public function setIdEnqueteResposta($idEnqueteResposta)
    {
        $this->idEnqueteResposta = $idEnqueteResposta;
    }

    /**
     * @return \TbUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param \TbUsuario $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }
}

