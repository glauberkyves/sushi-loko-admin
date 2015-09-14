<?php

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbRequisacaoTransacao
 *
 * @ORM\Table(name="tb_requisacao_transacao", indexes={@ORM\Index(name="fk_requisicaotransacao_usuario_idx", columns={"id_usuario"}), @ORM\Index(name="fk_requisicaotransacao_franqueador_idx", columns={"id_franqueador"})})
 * @ORM\Entity
 */
class TbRequisacaoTransacao extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_requisacao_transacao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRequisacaoTransacao;

    /**
     * @var string
     *
     * @ORM\Column(name="no_senha", type="string", length=100, nullable=false)
     */
    private $noSenha;

    /**
     * @var string
     *
     * @ORM\Column(name="nu_valor", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $nuValor;

    /**
     * @var integer
     *
     * @ORM\Column(name="st_utilizado", type="integer", nullable=false)
     */
    private $stUtilizado;

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

    /**
     * @var \TbFranqueador
     *
     * @ORM\ManyToOne(targetEntity="TbFranqueador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_franqueador", referencedColumnName="id_franqueador")
     * })
     */
    private $idFranqueador;

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
     * @var \TbFeedbackQuestaoResposta
     *
     * @ORM\ManyToOne(targetEntity="TbFeedbackQuestaoResposta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_feedback_questao_resposta", referencedColumnName="id_feedback_questao_resposta")
     * })
     */
    private $idFeedbackQuestaoResposta;

    /**
     * @var TbTransacao
     *
     * @ORM\OneToOne(targetEntity="Base\BaseBundle\Entity\TbTransacao", mappedBy="idRequisacaoTransacao")
     */
    protected $idTransacao;

    /**
     * @return int
     */
    public function getIdRequisacaoTransacao()
    {
        return $this->idRequisacaoTransacao;
    }

    /**
     * @param int $idRequisacaoTransacao
     */
    public function setIdRequisacaoTransacao($idRequisacaoTransacao)
    {
        $this->idRequisacaoTransacao = $idRequisacaoTransacao;
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
    public function getNuValor()
    {
        return $this->nuValor;
    }

    /**
     * @param string $nuValor
     */
    public function setNuValor($nuValor)
    {
        $this->nuValor = $nuValor;
    }

    /**
     * @return int
     */
    public function getStUtilizado()
    {
        return $this->stUtilizado;
    }

    /**
     * @param int $stUtilizado
     */
    public function setStUtilizado($stUtilizado)
    {
        $this->stUtilizado = $stUtilizado;
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
     * @return TbTransacao
     */
    public function getIdTransacao()
    {
        return $this->idTransacao ?: new TbTransacao();

    }

    /**
     * @param TbTransacao $idTransacao
     */
    public function setIdTransacao($idTransacao)
    {
        $this->idTransacao = $idTransacao;
    }

    /**
     * @return \TbFeedbackQuestaoResposta
     */
    public function getIdFeedbackQuestaoResposta()
    {
        return $this->idFeedbackQuestaoResposta ?: new TbFeedbackQuestaoResposta();
    }

    /**
     * @param \TbFeedbackQuestaoResposta $idFeedbackQuestaoResposta
     */
    public function setIdFeedbackQuestaoResposta($idFeedbackQuestaoResposta)
    {
        $this->idFeedbackQuestaoResposta = $idFeedbackQuestaoResposta;
    }
}