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

class FranqueadorOperadorRepository extends AbstractRepository
{
    public function findOperador(Request $request)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('fo')
            ->from('Base\BaseBundle\Entity\TbFranqueadorOperador', 'fo')
            ->innerJoin('fo.idOperador', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->where($expr->eq('pf.nuCpf', $expr->literal($request->request->getDigits('nuCpf'))))
            ->orWhere($expr->eq('pf.noEmail', $expr->literal($request->request->get('noEmail'))))
            ->getQuery()
            ->getResult();
    }

    public function fetchGrid(Request $request)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p.noPessoa, pf.noEmail, u.stAtivo, u.idUsuario, fo.idFranqueadorOperador')
            ->from('Base\BaseBundle\Entity\TbFranqueadorOperador', 'fo')
            ->innerJoin('fo.idOperador', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf');;
    }

}