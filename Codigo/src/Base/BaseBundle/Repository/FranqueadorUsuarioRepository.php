<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;


use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\Request;

class FranqueadorUsuarioRepository extends AbstractRepository
{
    public function findUsuarioPorFranqueador($nuCpf, $idFranqueador)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('Base\BaseBundle\Entity\TbFranqueadorUsuario', 'fu')
            ->innerJoin('Base\BaseBundle\Entity\TbUsuario', 'u', 'WITH', 'fu.idUsuario = u.idUsuario')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->innerJoin('fu.idFranqueador', 'f')
            ->innerJoin('f.idFranquia', 'ff')
            ->where($expr->eq('pf.nuCpf', $nuCpf))
            ->andWhere($expr->eq('fu.idFranqueador', $idFranqueador))
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findUsuarioPorFranquia($nuCpf, $idFranqueador)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->innerJoin('Base\BaseBundle\Entity\TbFranqueadorUsuario', 'fu', 'WITH', 'fu.idUsuario = u.idUsuario')
            ->innerJoin('fu.idFranqueador', 'f')
            ->innerJoin('f.idFranquia', 'ff')
            ->where($expr->eq('pf.nuCpf', $nuCpf))
            ->andWhere($expr->eq('ff.nuCodigoLoja', $idFranqueador))
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function fetchGrid(Request $request)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p.noPessoa, pf.noEmail, pf.nuCpf, u.idUsuario, f.idFranqueador, u.stAtivo')
            ->from('Base\BaseBundle\Entity\TbFranqueadorUsuario', 'fu')
            ->innerJoin('fu.idFranqueador', 'f')
            ->innerJoin('fu.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->andWhere($expr->eq('f.idFranqueador', $request->request->get('idFranqueador')))
            ->orderBy('u.idUsuario', 'DESC');
    }
}