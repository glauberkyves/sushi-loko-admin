<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

use Base\BaseBundle\Entity\AbstractEntity;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;


class PromocaoRepository extends AbstractRepository
{

    public function fetchGrid(Request $request)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('s.dtValidade','s.idPromocao','s.stAtivo','s.noPromocao')
            ->from('Base\BaseBundle\Entity\TbPromocao', 's');
    }


    public function addWhere(QueryBuilder $query, Request $request)
    {
        $expr = new Expr();
        foreach ($request->query->all() as $key => $value) {
            if ($value != '') {
                $typeColumn = $this->getTypeColumn($query, $key);
                switch ($typeColumn) {
                    case 'string':
                        $query->andWhere($expr->like("s.{$key}", $expr->literal('%' . $value . '%')));
                        break;
                    case 'integer':
                        $query->andWhere($expr->eq("s.{$key}", $value));
                        break;
                    default:
                        if ($key == 'dtValidade') {
                            $value = new \DateTime(str_replace("/", "-", $value));
                            $query->andWhere("s.{$key} = :dtValidade");
                            $query->setParameter('dtValidade', $value->format('Y-m-d'));
                        }
                        break;
                }
            }
        }
    }
}