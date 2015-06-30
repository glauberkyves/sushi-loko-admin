<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbFranqueador
 *
 * @ORM\Table(name="tb_franqueador")
 * @ORM\Entity
 */
class TbFranqueador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_franqueador", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFranqueador;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_pessoa", type="integer", nullable=false)
     */
    private $idPessoa;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_endereco", type="integer", nullable=false)
     */
    private $idEndereco;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_niveis", type="integer", nullable=false)
     */
    private $stNiveis;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_configuracao_franquia", type="integer", nullable=false)
     */
    private $idConfiguracaoFranquia;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_ativo", type="integer", nullable=false)
     */
    private $stAtivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=false)
     */
    private $dtCadastro;


}

