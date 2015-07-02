<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;


use Doctrine\ORM\Query\Expr;

class UsuarioRepository extends AbstractRepository
{
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        if (isset($criteria['nuCpf']) && $criteria['nuCpf']) {
            $expr   = new Expr();
            $result = $this
                ->getEntityManager()
                ->createQueryBuilder()
                ->select('u')
                ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
                ->innerJoin('u.idPessoa', 'p')
                ->innerJoin('p.idPessoaFisica', 'pf')
                ->where($expr->eq('pf.nuCpf', preg_replace("/[^\d]/", "", $criteria['nuCpf'])))
                ->andWhere($expr->eq('u.stAtivo', true))
                ->getQuery()
                ->getResult();

            return $result ? current($result) : array();
        }

        return parent::findOneBy($criteria, $orderBy);
    }
}