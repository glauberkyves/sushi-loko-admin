<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

use Base\BaseBundle\Service\Data;
use Doctrine\ORM\Query\Expr;
use Super\TransacaoBundle\Service\TipoTransacao;
use Symfony\Component\HttpFoundation\Request;
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
        $debito  = $queryDebito ? $queryDebito[0]['debito'] : 0;

        return $credito - $debito;
    }

    public function getTransacaoFranqueador(Request $request)
    {
        $expr = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('t.idTransacao, t.dtCadastro, tt.noTipoTransacao, t.stAtivo, p.noPessoa, pf.noEmail, pf.nuCpf, t.nuValor, ff.noFranquia')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idTipoTransacao', 'tt')
            ->innerJoin('t.idFranqueador', 'f')
            ->innerJoin('t.idFranquia', 'ff')
            ->innerJoin('t.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->andWhere($expr->eq('f.idFranqueador', $request->query->get('idFranqueador')));

        switch (true) {
            case $request->get('dtCadastro'):
                $dtCadastro = Data::dateBr($request->query->get('dtCadastro'));

                $query->andWhere($expr->gte('t.dtCadastro', $expr->literal($dtCadastro->format('Y-m-d H:i:s'))));

                $dtCadastro->modify('+1 day');
                $query->andWhere($expr->lte('t.dtCadastro', $expr->literal($dtCadastro->format('Y-m-d H:i:s'))));
                break;

            case $request->query->getDigits('nuCpf'):
                $query->andWhere($expr->eq('pf.nuCpf', $expr->literal($request->query->getDigits('nuCpf'))));
                break;

            case $request->query->get('idTipoTransacao'):
                $query->andWhere($expr->eq('tt.idTipoTransacao', $request->query->get('idTipoTransacao')));
                break;

            case $request->query->get('idFranquia'):
                $query->andWhere($expr->eq('ff.idFranquia', $request->query->get('idFranquia')));
                break;
        }

        return $query->getQuery()
            ->getResult();
    }

    public function getTransacaoFranquia(Request $request)
    {
        $expr = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('t.idTransacao, t.dtCadastro, tt.noTipoTransacao, t.stAtivo, p.noPessoa, pf.noEmail, pf.nuCpf, t.nuValor')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idTipoTransacao', 'tt')
            ->innerJoin('t.idFranquia', 'f')
            ->innerJoin('t.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->andWhere($expr->eq('f.idFranquia', $request->query->get('idFranquia')));

        switch (true) {
            case $request->get('dtCadastro'):
                $dtCadastro = Data::dateBr($request->query->get('dtCadastro'));

                $query->andWhere($expr->gte('t.dtCadastro', $expr->literal($dtCadastro->format('Y-m-d H:i:s'))));

                $dtCadastro->modify('+1 day');
                $query->andWhere($expr->lte('t.dtCadastro', $expr->literal($dtCadastro->format('Y-m-d H:i:s'))));
                break;

            case $request->query->getDigits('nuCpf'):
                $query->andWhere($expr->eq('pf.nuCpf', $expr->literal($request->query->getDigits('nuCpf'))));
                break;

            case $request->query->get('idTipoTransacao'):
                $query->andWhere($expr->eq('tt.idTipoTransacao', $request->query->get('idTipoTransacao')));
                break;
        }

        return $query->getQuery()
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
        $queryDebito  = ($queryDebito) ? $queryDebito[0] : 0;

        return $queryCredito + $queryDebito;
    }

    public function getRemoveTagsByIdUsuario($idUsuario = 0)
    {
        $expr       = new Expr();
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
        $expr       = new Expr();
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

    public function getFranquiaVisitada($idUsuario = 0)
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

    public function getExtratoPorUsuario($idUsuario = 0)
    {
        $expr       = new Expr();
        $dtCadastro = new \DateTime();
        $dtCadastro->modify('-3 months');

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('f.idFranquia, f.noFranquia, tt.idTipoTransacao, tt.noTipoTransacao, t.nuValor, t.dtCadastro')
            ->from('Base\BaseBundle\Entity\TbTransacao', 't')
            ->innerJoin('t.idTipoTransacao', 'tt')
            ->innerJoin('t.idFranquia', 'f')
            ->innerJoin('t.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->where($expr->eq('u.idUsuario', $idUsuario))
            ->andWhere('tt.idTipoTransacao = 1 OR tt.idTipoTransacao = 2')
            ->andWhere('t.dtCadastro >= :dtCadastro')
            ->andWhere('t.stAtivo = :stAtivo')
            ->setParameter('dtCadastro', $dtCadastro->format("Y-m-d H:i:s"))
            ->setParameter('stAtivo', true)
            ->getQuery()
            ->getResult();
    }
}