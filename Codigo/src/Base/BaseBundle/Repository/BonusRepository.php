<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

use Base\BaseBundle\Entity\TbFranqueadorUsuario;
use Doctrine\ORM\Query\Expr;

class BonusRepository extends AbstractRepository
{

    public function getBonus(TbFranqueadorUsuario $idFranqueadorUsuario)
    {
        $exp = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('sum(b.nuBonus)')
            ->from('Base\BaseBundle\Entity\TbBonus', 'b')
            ->innerJoin('b.idFranqueadorUsuario', 'fu')
            ->where($exp->eq('b.stAtivo', true))
            ->andWhere($exp->eq('b.stVencido', 0))
            ->andWhere($exp->eq('fu.idFranqueadorUsuario', $idFranqueadorUsuario->getIdFranqueadorUsuario()))
            ->getQuery()
            ->getResult();

        return $query ? $query[0][1] : 0;
    }
}