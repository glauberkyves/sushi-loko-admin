<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEnqueteRespostaUsuario
 *
 * @ORM\Table(name="tb_enquete_resposta_usuario", indexes={@ORM\Index(name="id_enquete_resposta", columns={"id_enquete_resposta"}), @ORM\Index(name="id_usuario", columns={"id_usuario"}), @ORM\Index(name="id_enquete", columns={"id_enquete"})})
 * @ORM\Entity
 */
class TbEnqueteRespostaUsuario
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
     * @var \TbEnquete
     *
     * @ORM\ManyToOne(targetEntity="TbEnquete")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_enquete", referencedColumnName="id_enquete")
     * })
     */
    private $idEnquete;


}

