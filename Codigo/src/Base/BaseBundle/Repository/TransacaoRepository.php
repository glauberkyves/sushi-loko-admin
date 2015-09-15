<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

use Doctrine\ORM\Query\Expr;
use Super\TransacaoBundle\Service\TipoTransacao;
use Symfony\Component\Validator\Constraints\DateTime;

class TransacaoRepository extends AbstractRepository
{

    public function getCreditosUsuario($idUsuario, $idFranqueador)
    {
        $expr = new Expr();

        $queryCredito = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('SUM(t.nuValor) credito')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idTipoTransacao', 'tt')
            ->innerJoin('t.idUsuario', 'u')
            ->innerJoin('t.idFranquia', 'ff')
            ->innerJoin('ff.idFranqueador', 'f')
            ->where($expr->eq('u.idUsuario', $idUsuario))
            ->andWhere($expr->eq('ff.idFranqueador', $idFranqueador))
            ->andWhere($expr->eq('t.stAtivo', true))
            ->andWhere($expr->eq('tt.idTipoTransacao', TipoTransacao::CREDITO))
            ->getQuery()
            ->getResult();

        $queryDebito = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('SUM(t.nuValor) debito')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idTipoTransacao', 'tt')
            ->innerJoin('t.idUsuario', 'u')
            ->innerJoin('t.idFranquia', 'ff')
            ->innerJoin('ff.idFranqueador', 'f')
            ->where($expr->eq('u.idUsuario', $idUsuario))
            ->andWhere($expr->eq('ff.idFranqueador', $idFranqueador))
            ->andWhere($expr->eq('t.stAtivo', true))
            ->andWhere($expr->eq('tt.idTipoTransacao', TipoTransacao::DEBITO))
            ->getQuery()
            ->getResult();

        $credito = $queryCredito ? $queryCredito[0]['credito'] : 0;
        $debito = $queryDebito ? $queryDebito[0]['debito'] : 0;

        return $credito - $debito;
    }

    public function getTransacaoFranqueador($idFranqueador)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('t.idTransacao, t.dtCadastro, tt.noTipoTransacao, t.stAtivo, p.noPessoa, pf.noEmail, pf.nuCpf, t.nuValor')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idTipoTransacao', 'tt')
            ->innerJoin('t.idFranqueador', 'f')
            ->innerJoin('t.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->andWhere($expr->eq('f.idFranqueador', $idFranqueador))
            ->getQuery()
            ->getResult();
    }

    public function getTransacaoFranquia($idFranquia)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('t.idTransacao, t.dtCadastro, tt.noTipoTransacao, t.stAtivo, p.noPessoa, pf.noEmail, pf.nuCpf, t.nuValor')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idTipoTransacao', 'tt')
            ->innerJoin('t.idFranquia', 'f')
            ->innerJoin('t.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->andWhere($expr->eq('f.idFranquia', $idFranquia))
            ->getQuery()
            ->getResult();
    }

    public function getTransacoesCredito($nuMes = 0, $idFranqueador = 0)
    {
        $query = $this
            ->createQueryBuilder('t')
            ->select('COUNT(t) transacaoCredito, MONTH(t.dtCadastro) nuMes, DAY(t.dtCadastro) dtCadastro')
            ->innerJoin('t.idFranquia', 'ff')
            ->where('t.idTipoTransacao = 1')
            ->having('nuMes = :nuMes')
            ->groupBy('dtCadastro')
            ->orderBy('dtCadastro', 'ASC')
            ->setParameter('nuMes', $nuMes);

        if ($idFranqueador) {
            $query
                ->innerJoin('ff.idFranqueador', 'f')
                ->andWhere('f.idFranqueador = :idFranqueador')
                ->setParameter('idFranqueador', $idFranqueador);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    public function getTransacoesDebito($nuMes = 0, $idFranqueador = 0)
    {
        $query = $this
            ->createQueryBuilder('t')
            ->select('COUNT(t) transacaoDebito, MONTH(t.dtCadastro) nuMes, DAY(t.dtCadastro) dtCadastro')
            ->innerJoin('t.idFranquia', 'ff')
            ->where('t.idTipoTransacao = 2');

        if ($idFranqueador) {
            $query
                ->innerJoin('ff.idFranqueador', 'f')
                ->andWhere('f.idFranqueador = :idFranqueador')
                ->setParameter('idFranqueador', $idFranqueador);
        }

        return $query
            ->having('nuMes = :nuMes')
            ->groupBy('dtCadastro')
            ->orderBy('dtCadastro', 'ASC')
            ->setParameter('nuMes', $nuMes)
            ->getQuery()
            ->getResult();
    }

    public function getTransacoes($nuMes = 0, $idFranqueador = 0)
    {
        $queryCredito = $this
            ->createQueryBuilder('t')
            ->select('COUNT(t) transacaoCredito, SUM(t.nuValor) valorCredito, MONTH(t.dtCadastro) nuMes, DAY(t.dtCadastro) dtCadastro')
            ->innerJoin('t.idFranquia', 'ff')
            ->where('t.idTipoTransacao = 1')
            ->groupBy("dtCadastro")
            ->having('nuMes = :nuMes')
            ->setParameter('nuMes', $nuMes);

        $queryDebito = $this
            ->createQueryBuilder('t')
            ->select('COUNT(t) transacaoDebito, SUM(t.nuValor) valorDebito, MONTH(t.dtCadastro) nuMes, DAY(t.dtCadastro) dtCadastro')
            ->innerJoin('t.idFranquia', 'ff')
            ->where('t.idTipoTransacao = 2')
            ->groupBy("dtCadastro")
            ->having('nuMes = :nuMes')
            ->setParameter('nuMes', $nuMes);

        if ($idFranqueador) {
            $queryCredito
                ->innerJoin('ff.idFranqueador', 'f')
                ->andWhere('f.idFranqueador = :idFranqueador')
                ->setParameter('idFranqueador', $idFranqueador);
            $queryDebito
                ->innerJoin('ff.idFranqueador', 'f')
                ->andWhere('f.idFranqueador = :idFranqueador')
                ->setParameter('idFranqueador', $idFranqueador);
        }

        $queryCredito = $queryCredito
            ->getQuery()
            ->getResult();

        $queryDebito = $queryDebito
            ->getQuery()
            ->getResult();

        $queryCredito = ($queryCredito) ? $queryCredito[0] : 0;
        $queryDebito = ($queryDebito) ? $queryDebito[0] : 0;

        return $queryCredito + $queryDebito;
    }

    public function getRemoveTagsByIdUsuario($idUsuario = 0)
    {
        $expr = new Expr();
        $dtCadastro = new \DateTime();
        $dtCadastro->modify('-3 months');

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('f.idFranquia')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idTipoTransacao', 'tt')
            ->innerJoin('t.idFranquia', 'f')
            ->innerJoin('t.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->where($expr->eq('u.idUsuario', $idUsuario))
            ->andWhere('tt.idTipoTransacao = 1 OR tt.idTipoTransacao = 2')
            ->andWhere('t.dtCadastro < :dtCadastro')
            ->groupBy('t.idFranquia')
            ->setParameter('dtCadastro', $dtCadastro->format("Y-m-d H:i:s"))
            ->getQuery()
            ->getResult();
    }

    public function getSendTagsByIdUsuario($idUsuario = 0)
    {
        $expr = new Expr();
        $dtCadastro = new \DateTime();
        $dtCadastro->modify('-3 months');

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('f.idFranquia')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idTipoTransacao', 'tt')
            ->innerJoin('t.idFranquia', 'f')
            ->innerJoin('t.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->where($expr->eq('u.idUsuario', $idUsuario))
            ->andWhere('tt.idTipoTransacao = 1 OR tt.idTipoTransacao = 2')
            ->andWhere('t.dtCadastro >= :dtCadastro')
            ->groupBy('t.idFranquia')
            ->setParameter('dtCadastro', $dtCadastro->format("Y-m-d H:i:s"))
            ->getQuery()
            ->getResult();
    }

    public function getFranquiaVisitada($idUsuario)
    {
        $exp = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('f.noFranquia')
            ->addSelect(
                '(' .
                $this
                    ->getEntityManager()
                    ->createQueryBuilder()
                    ->select('DISTINCT COUNT(t1.idTransacao)')
                    ->from('Base\BaseBundle\Entity\TbTransacao', 't1')
                    ->innerJoin('t1.idFranquia', 'f1')
                    ->where($exp->eq('f1.idFranquia', 'f.idFranquia'))
                . ') franquia')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idFranquia', 'f')
            ->addOrderBy('t.idTransacao', 'ASC')
            ->getQuery()
            ->getResult();

        return $query ? $query[0]['noFranquia'] : '';
    }
}