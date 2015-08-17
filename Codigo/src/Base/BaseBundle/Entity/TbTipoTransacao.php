<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbTipoTransacao
 *
 * @ORM\Table(name="tb_tipo_transacao")
 * @ORM\Entity
 */
class TbTipoTransacao extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_transacao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTipoTransacao;

    /**
     * @var string
     *
     * @ORM\Column(name="no_tipo_transacao", type="string", length=45, nullable=false)
     */
    private $noTipoTransacao;

    /**
     * @return int
     */
    public function getIdTipoTransacao()
    {
        return $this->idTipoTransacao;
    }

    /**
     * @param int $idTipoTransacao
     */
    public function setIdTipoTransacao($idTipoTransacao)
    {
        $this->idTipoTransacao = $idTipoTransacao;
    }

    /**
     * @return string
     */
    public function getNoTipoTransacao()
    {
        return $this->noTipoTransacao;
    }

    /**
     * @param string $noTipoTransacao
     */
    public function setNoTipoTransacao($noTipoTransacao)
    {
        $this->noTipoTransacao = $noTipoTransacao;
    }
}