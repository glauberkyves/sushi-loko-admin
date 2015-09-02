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
            ->andWhere($expr->in('tt.idTipoTransacao', array(TipoTransacao::CREDITO, TipoTransacao::CREDITO_AVULSO)))
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
}