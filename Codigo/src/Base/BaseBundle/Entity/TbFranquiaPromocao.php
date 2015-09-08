<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranquiaPromocao
 *
 * @ORM\Table(name="tb_franquia_promocao", indexes={@ORM\Index(name="fk_franquiapromocao_franquia_idx", columns={"id_franquia"}), @ORM\Index(name="fk_franquiapromocao_promocao_idx", columns={"id_promocao"})})
 * @ORM\Entity(repositoryClass="Base\BaseBundle\Repository\FranquiaPromocaoRepository")
 */
class TbFranquiaPromocao extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franquia_promocao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranquiaPromocao;

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
     * @var \TbPromocao
     *
     * @ORM\ManyToOne(targetEntity="Base\BaseBundle\Entity\TbPromocao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_promocao", referencedColumnName="id_promocao")
     * })
     */
    private $idPromocao;

    /**
     * @return int
     */
    public function getIdFranquiaPromocao()
    {
        return $this->idFranquiaPromocao;
    }

    /**
     * @param int $idFranquiaPromocao
     */
    public function setIdFranquiaPromocao($idFranquiaPromocao)
    {
        $this->idFranquiaPromocao = $idFranquiaPromocao;
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
     * @return \TbPromocao
     */
    public function getIdPromocao()
    {
        return $this->idPromocao;
    }

    /**
     * @param \TbPromocao $idPromocao
     */
    public function setIdPromocao($idPromocao)
    {
        $this->idPromocao = $idPromocao;
    }
}

