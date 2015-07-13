<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 06/07/2015
 * Time: 16:55
 */

namespace Base\BaseBundle\Repository;

use Base\BaseBundle\Entity\AbstractEntity;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class FranqueadorRepository extends AbstractRepository
{
    public function fetchGrid(Request $request)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('e.idFranqueador, e.noRazaoSocial, e.stAtivo')
            ->addSelect('(' .
                $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('COUNT(f1.idFranquia)')
                    ->from('Base\BaseBundle\Entity\TbFranquia', 'f1')
                    ->where($expr->eq('f1.idFranqueador', 'e.idFranqueador'))
                    ->getQuery()
                    ->getDQL()
                . ') totalFranquia'
            )
            ->from('Base\BaseBundle\Entity\TbFranqueador', 'e')
            ->innerJoin('e.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->addOrderBy('e.idFranqueador', 'desc');
    }

    public function selectLocalidade()
    {
        $arrLocalidade = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'a.idFranqueador, e.noLatitude, e.noLongitude'
            )
            ->from('BaseBaseBundle:TbFranqueador', 'a')
            ->innerJoin('a.idEndereco', 'e')
            ->getQuery()
            ->getArrayResult();

        return $arrLocalidade;
    }

}