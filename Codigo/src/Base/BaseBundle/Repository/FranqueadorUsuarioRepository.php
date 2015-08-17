<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;


use Doctrine\ORM\Query\Expr;

class FranqueadorUsuarioRepository extends AbstractRepository
{
    public function findUsuarioPorFranquia($nuCpf, $nuCodigoLoja)
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
            ->andWhere($expr->eq('ff.nuCodigoLoja', $nuCodigoLoja))
            ->getQuery()
            ->getOneOrNullResult();
    }
}