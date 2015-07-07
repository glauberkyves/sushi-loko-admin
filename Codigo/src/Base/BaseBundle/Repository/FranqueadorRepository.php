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

class FranqueadorRepository extends AbstractRepository {

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