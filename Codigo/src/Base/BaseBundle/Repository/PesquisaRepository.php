<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 28/08/2015
 * Time: 15:39
 */

namespace Base\BaseBundle\Repository;

use Base\BaseBundle\Service\Data;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Super\TransacaoBundle\Service\TipoTransacao;
use Base\BaseBundle\Service\Pesquisa;

class PesquisaRepository extends AbstractRepository
{
    public function fetchGrid(Request $request)
    {
        $request = $this->padronizarRequest($request);

        $subQueryCreditoTotal   = $this->subQueryCredito($request, false, 1);
        $subQueryDebitoTotal    = $this->subQueryDebito($request, false, 2);
        $subQueryCreditoPeriodo = $this->subQueryCredito($request, true, 3);
        $subQueryDebitoPeriodo  = $this->subQueryDebito($request, true, 4);

        $subQueryCount = $this->subQueryCountTransacao($request);
        $subQueryMedia = $this->subQueryMediaConsumo($request);

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('u.stAtivo, u.idUsuario, p.noPessoa, pf.sgSexo, pf.noEmail')
            ->addSelect('(' . $subQueryCreditoTotal . ') nuCreditoTotal')
            ->addSelect('(' . $subQueryDebitoTotal . ') nuDebitoTotal')
            ->addSelect('(' . $subQueryCreditoPeriodo . ') nuCreditoPeriodo')
            ->addSelect('(' . $subQueryDebitoPeriodo . ') nuDebitoPeriodo')
            ->addSelect('(' . $subQueryCount . ') nuTransacao')
            ->addSelect('(' . $subQueryMedia . ') nuMediaConsumo')
            ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->innerJoin('u.idFranqueadorUsuario', 'fu')
            ->where('u.stAtivo = :stAtivo')
            ->andWhere('fu.idFranqueador = :idFranqueador')
            ->groupBy('u.idUsuario')
            ->orderBy('p.noPessoa', 'ASC')
            ->setParameter('stAtivo', true)
            ->setParameter('idFranqueador', $request->query->get('idFranqueador'));

        return $query;
    }

    public function addWhere(QueryBuilder $query, Request $request)
    {
        $expr    = new Expr();
        $request = $request->query;

        foreach ($request->all() as $key => $value) {
            switch ($key) {
                #filtro por sexo [u = unisex]
                case 'sgSexo':
                    if (strlen($value) == 1 && $value != 'u') {
                        $query->andWhere("pf.{$key} = :sgSexo");
                        $query->setParameter('sgSexo', $value, \PDO::PARAM_STR);
                    }
                    break;
                #filtro por idade minima
                case 'nuIdadeMin':
                    if (is_numeric($value) && $value > 0) {
                        $dtMin = $this->getDataModificada($value, 'a');
                        $query->andWhere('pf.dtNascimento <= :dtMin');
                        $query->setParameter('dtMin', $dtMin);
                    }
                    break;
                #filtro por idade maxima
                case 'nuIdadeMax':
                    if (is_numeric($value) && $value > 0) {
                        $dtMax = $this->getDataModificada($value, 'a');
                        $query->andWhere('pf.dtNascimento >= :dtMax');
                        $query->setParameter('dtMax', $dtMax);
                    }
                    break;
                #filtro por atividade
                case 'nuAtividade':
                    if (is_numeric($value)) {
                        switch (true) {
                            case $value == 0:
                                $query->having('nuTransacao >= 0');
                                break;
                            case $value == 1:
                                $query->having('nuTransacao > 0');
                                break;
                            case $value == 2:
                                $query->having('nuTransacao = 0');
                                break;
                        }
                    }
                    break;
                #filtro por quem obteve bonus
                case 'nuCreditoPeriodo':
                    if (is_numeric($value) && $value > 0) {
                        $query->andHaving("nuCreditoPeriodo > 0");
                    }
                    break;
                #filtro por quem utilizou bonus
                case 'nuDebitoPeriodo':
                    if (is_numeric($value) && $value > 0) {
                        $query->andHaving("nuDebitoPeriodo > 0");
                    }
                    break;
                #filtro por media de consumo
                case 'nuMediaConsumo':
                    $value = floatval(str_replace(',', '.', str_replace('.', '', $value)));
                    if (is_numeric($value) && $value > 0) {
                        $op = Pesquisa::getOperador($request->get('noMediaConsumo'));
                        $query->andHaving("nuMediaConsumo {$op} :media");
                        $query->setParameter('media', $value);
                    }
                    break;
                #filtro por saldo de bonus
                case 'nuSaldoBonus':
                    $value = floatval(str_replace(',', '.', str_replace('.', '', $value)));
                    if (is_numeric($value) && $value > 0) {
                        $op = Pesquisa::getOperador($request->get('noSaldoBonus'));
                        $query->andHaving("(nuCreditoTotal - nuDebitoTotal) {$op} :saldo");
                        $query->setParameter('saldo', $value, \PDO::PARAM_INT);
                    }
                    break;
                #filtro por per�odo de cadastro
                case 'nuCadastro':
                    if (is_numeric($value) && $value > 0) {
                        $dtCadastro = $this->getDataModificada($value, $request->get('noCadastro'));
                        $query->andWhere('u.dtCadastro >= :dtCadastro');
                        $query->setParameter('dtCadastro', $dtCadastro);
                    }
                    break;
                #filtro (consumo at� hoje)
                case 'nuConsumoTotal':
                    $value = floatval(str_replace(',', '.', str_replace('.', '', $value)));
                    if (is_numeric($value) && $value > 0) {
                        $query->andHaving("nuDebitoTotal >= :debito");
                        $query->setParameter('debito', $value, \PDO::PARAM_INT);
                    }
                    break;
                #filtro aniversariante
                case 'nuAniversariante':
                    $query->andWhere('MONTH(pf.dtNascimento) = :dtNascimento');
                    $query->setParameter('dtNascimento', date('m'));
                    break;

                #filtro data
                case 'dtInicio':
                    $data = Data::dateBr($value);
                    $query->andWhere($expr->gte('u.dtCadastro', $data->format('d/m/Y H:i:s')));
                    break;

                #filtro data
                case 'dtFim':
                    $data = Data::dateBr($value);
                    $query->andWhere($expr->lte('u.dtCadastro', $data->format('d/m/Y') . ' 59:59:59'));
                    break;
            }
        }
    }

    /**
     * Credito total ou por periodo
     */
    private function subQueryCredito(Request $request, $filtrarPeriodo = false, $i = 1)
    {
        $request = $request->query;
        $expr    = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select("SUM(t{$i}.nuValor)")
            ->from('Base\BaseBundle\Entity\TbTransacao', "t{$i}")
            ->innerJoin("t{$i}.idTipoTransacao", "tt{$i}")
            ->innerJoin("t{$i}.idUsuario", "u{$i}")
            ->innerJoin("t{$i}.idFranquia", "ff{$i}")
            ->innerJoin("ff{$i}.idFranqueador", "f{$i}")
            ->where($expr->eq("f{$i}.idFranqueador", $request->get('idFranqueador')))
            ->andWhere($expr->in("ff{$i}.idFranquia", $request->get('idFranqueado', array(0))))
            ->orWhere($expr->eq("t{$i}.idFranqueador", $request->get('idFranqueador')))
            ->andWhere($expr->eq("u{$i}.idUsuario", "u.idUsuario"))
            ->andWhere($expr->eq("t{$i}.stAtivo", true))
            ->andWhere($expr->eq("tt{$i}.idTipoTransacao", TipoTransacao::CREDITO));

        if ($filtrarPeriodo) {
            #filtro por pessoas que obtiveram b�nus no periodo informado
            $nuCreditoPeriodo = $request->get('nuCreditoPeriodo');
            if (is_numeric($nuCreditoPeriodo) && $nuCreditoPeriodo > 0) {
                $dtCadastro = $this->getDataModificada($nuCreditoPeriodo, $request->get('noCreditoPeriodo'));
                $query->andWhere("t{$i}.dtCadastro >= '" . $dtCadastro->format("Y-m-d H:i:s") . "'");
            }
        }

        return $query->getQuery()->getDQL();
    }

    /**
     * Debito total ou por periodo
     */
    private function subQueryDebito(Request $request, $filtrarPeriodo = false, $i = 2)
    {
        $request = $request->query;
        $expr    = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select("SUM(t{$i}.nuValor)")
            ->from('Base\BaseBundle\Entity\TbTransacao', "t{$i}")
            ->innerJoin("t{$i}.idTipoTransacao", "tt{$i}")
            ->innerJoin("t{$i}.idUsuario", "u{$i}")
            ->innerJoin("t{$i}.idFranquia", "ff{$i}")
            ->innerJoin("ff{$i}.idFranqueador", "f{$i}")
            ->where($expr->eq("f{$i}.idFranqueador", $request->get('idFranqueador')))
            ->andWhere($expr->in("ff{$i}.idFranquia", $request->get('idFranqueado', array(0))))
            ->andWhere($expr->eq("u{$i}.idUsuario", "u.idUsuario"))
            ->andWhere($expr->eq("t{$i}.stAtivo", true))
            ->andWhere($expr->eq("tt{$i}.idTipoTransacao", TipoTransacao::DEBITO));

        if ($filtrarPeriodo) {
            #filtro por pessoas que utilizaram b�nus no periodo informado
            $nuDebitoPeriodo = $request->get('nuDebitoPeriodo');
            if (is_numeric($nuDebitoPeriodo) && $nuDebitoPeriodo > 0) {
                $dtCadastro = $this->getDataModificada($nuDebitoPeriodo, $request->get('noDebitoPeriodo'));
                $query->andWhere("t{$i}.dtCadastro >= '" . $dtCadastro->format("Y-m-d H:i:s") . "'");
            }
        }

        return $query->getQuery()->getDQL();
    }

    /**
     * Quantidade de transacoes realizadas por usuario
     */
    private function subQueryCountTransacao(Request $request)
    {
        $request = $request->query;
        $expr    = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('COUNT(t5)')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't5')
            ->innerJoin('t5.idTipoTransacao', 'tt5')
            ->innerJoin('t5.idUsuario', 'u5')
            ->innerJoin('t5.idFranquia', 'ff5')
            ->innerJoin('ff5.idFranqueador', 'f5')
            ->where($expr->eq('f5.idFranqueador', $request->get('idFranqueador')))
            ->andWhere($expr->in('ff5.idFranquia', $request->get('idFranqueado', array(0))))
            ->andWhere($expr->eq('u5.idUsuario', 'u.idUsuario'))
            ->andWhere($expr->eq('t5.stAtivo', true))
            ->andWhere($expr->in('tt5.idTipoTransacao', array(TipoTransacao::CREDITO, TipoTransacao::DEBITO)));

        #filtro (nos ultimos dias ou meses)
        $nuPeriodo = $request->get('nuPeriodo');
        if (is_numeric($nuPeriodo) && $nuPeriodo > 0) {
            $dtCadastro = $this->getDataModificada($nuPeriodo, $request->get('noCadastro'));
            $query->andWhere("t5.dtCadastro >= '" . $dtCadastro->format("Y-m-d H:i:s") . "'");
        }

        return $query->getQuery()->getDQL();
    }

    /**
     * Media de consumo por usuario
     */
    private function subQueryMediaConsumo(Request $request)
    {
        $request = $request->query;
        $expr    = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('AVG(t6.nuValor)')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't6')
            ->innerJoin('t6.idTipoTransacao', 'tt6')
            ->innerJoin('t6.idUsuario', 'u6')
            ->innerJoin('t6.idFranquia', 'ff6')
            ->innerJoin('ff6.idFranqueador', 'f6')
            ->where($expr->eq('f6.idFranqueador', $request->get('idFranqueador')))
            ->andWhere($expr->in('ff6.idFranquia', $request->get('idFranqueado', array(0))))
            ->andWhere($expr->eq('u6.idUsuario', 'u.idUsuario'))
            ->andWhere($expr->eq('t6.stAtivo', true))
            ->andWhere($expr->eq('tt6.idTipoTransacao', TipoTransacao::DEBITO));

        return $query->getQuery()->getDQL();
    }

    /**
     * Modificar data
     * @param int $nuPeriodo
     * @param string $noPeriodo
     * @return \DateTime
     */
    private function getDataModificada($nuPeriodo = 0, $noPeriodo = '')
    {
        if ($nuPeriodo && $noPeriodo) {
            $noPeriodo = Pesquisa::getPeriodo($noPeriodo);
            $dateTime  = new \DateTime();
            $dateTime->modify("-{$nuPeriodo} {$noPeriodo}");

            return $dateTime;
        }

        return new \DateTime();
    }

    /**
     * Padronizar variaveis da requisicao
     * @param Request $request
     * @return Request
     */
    private function padronizarRequest(Request $request)
    {
        //caso seja uma busca por quem obteve e utilizou bonus
        //sobrescrever as variaveis p/ continuar o fluxo da aplicacao
        $r = $request->query;
        if ($nuBonus = $r->get('nuBonusTransacionado')) {
            if (is_numeric($nuBonus) && $nuBonus > 0) {
                $request->query->set('nuDebitoPeriodo', $nuBonus);
                $request->query->set('nuCreditoPeriodo', $nuBonus);
                $request->query->set('noDebitoPeriodo', $r->get('noBonusTransacionado'));
                $request->query->set('noCreditoPeriodo', $r->get('noBonusTransacionado'));
            }
        }

        return $request;
    }
}