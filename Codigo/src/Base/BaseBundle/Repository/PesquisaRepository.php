<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 28/08/2015
 * Time: 15:39
 */

namespace Base\BaseBundle\Repository;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Super\TransacaoBundle\Service\TipoTransacao;

class PesquisaRepository extends AbstractRepository
{
    public function fetchGrid(Request $request)
    {
        $subQueryCredito = $this->subQueryCredito($request);
        $subQueryDebito  = $this->subQueryDebito($request);

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('u.idUsuario')
            ->addSelect('(' . $subQueryCredito . ') credito')
            ->addSelect('(' . $subQueryDebito . ') debito')
            ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf');

        return $query;
    }

    public function addWhere(QueryBuilder $query, Request $request)
    {
        $expr = new Expr();
        foreach ($request->query->all() as $key => $value) {
            switch($key) {
                case 'sgSexo':
                    if($value != 'u') {
                        $query->andWhere("pf.$key = :sgSexo");
                        $query->setParameter('sgSexo', $value, \PDO::PARAM_STR);
                    }
                    break;
                case 'nuSaldoBonus':
                    if($value > 0) {
                        $operador = $this->getOperador($request->query->get('noSaldoBonus'));
                        $query->having("(credito - debito) $operador :saldo");
                        $query->setParameter('saldo', $value, \PDO::PARAM_INT);
                    }
                    break;
                case 'nuIdadeMin':
                    if($value > 0) {
                        $dtMin = new \DateTime();
                        $dtMin->modify("-$value years");
                        $query->andWhere("pf.dtNascimento <= :dtMin");
                        $query->setParameter('dtMin', $dtMin);
                    }
                    break;
                case 'nuIdadeMax':
                    if($value > 0) {
                        $dtMax = new \DateTime();
                        $dtMax->modify("-$value years");
                        $query->andWhere("pf.dtNascimento >= :dtMax");
                        $query->setParameter('dtMax', $dtMax);
                    }
                    break;
            }
        }
    }

    private function subQueryCredito($request)
    {
        $expr = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('SUM(t1.nuValor)')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't1')
            ->innerJoin('t1.idTipoTransacao', 'tt1')
            ->innerJoin('t1.idUsuario', 'u1')
            ->innerJoin('t1.idFranquia', 'ff1')
            ->innerJoin('ff1.idFranqueador', 'f1')
            ->where($expr->eq('u1.idUsuario', 'u.idUsuario'))
            ->andWhere($expr->eq('t1.stAtivo', true))
            ->andWhere($expr->eq('tt1.idTipoTransacao', TipoTransacao::CREDITO));

        if($idFranqueador = $request->query->get('idFranqueador')) {
            $query->andWhere($expr->eq('ff1.idFranqueador', $idFranqueador));
        }

        return $query->getQuery()->getDQL();
    }

    private function subQueryDebito($request)
    {
        $expr = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('SUM(t2.nuValor)')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't2')
            ->innerJoin('t2.idTipoTransacao', 'tt2')
            ->innerJoin('t2.idUsuario', 'u2')
            ->innerJoin('t2.idFranquia', 'ff2')
            ->innerJoin('ff2.idFranqueador', 'f2')
            ->where($expr->eq('u2.idUsuario', 'u.idUsuario'))
            ->andWhere($expr->eq('t2.stAtivo', true))
            ->andWhere($expr->eq('tt2.idTipoTransacao', TipoTransacao::DEBITO));

        if($idFranqueador = $request->query->get('idFranqueador')) {
            $query->andWhere($expr->eq('ff2.idFranqueador', $idFranqueador));
        }

        return $query->getQuery()->getDQL();
    }

    private function getOperador($operador = 'igual')
    {
        switch($operador)
        {
            case 'igual':
                return '=';
            case 'maior':
                return '>';
            case 'menor':
                return '<';
        }
    }

    private function getTempo($tempo = 'dia')
    {
        switch($tempo)
        {
            case 'dia':
                return 'days';
            case 'mes':
                return 'months';
            case 'ano':
                return 'years';
        }
    }
}