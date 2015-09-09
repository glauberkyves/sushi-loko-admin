<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class PromocaoRepository extends AbstractRepository
{
    public function fetchGrid(Request $request)
    {
        $idFranqueador = $request->query->get('idFranqueador', 0);

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p.dtValidade, p.idPromocao, p.stAtivo, p.noPromocao')
            ->from('Base\BaseBundle\Entity\TbPromocao', 'p')
            ->where('p.idFranqueador = :idFranqueador')
            ->setParameter('idFranqueador', $idFranqueador);
    }

    public function addWhere(QueryBuilder $query, Request $request)
    {
        $expr = new Expr();
        foreach ($request->query->all() as $key => $value) {
            if ($value != '') {
                $typeColumn = $this->getTypeColumn($query, $key);
                switch ($typeColumn) {
                    case 'string':
                        $query->andWhere($expr->like("p.{$key}", $expr->literal('%' . $value . '%')));
                        break;
                    case 'integer':
                        $query->andWhere($expr->eq("p.{$key}", $value));
                        break;
                    default:
                        if ($key == 'dtValidade') {
                            $value = new \DateTime(str_replace("/", "-", $value));
                            $query->andWhere("p.{$key} = :dtValidade");
                            $query->setParameter('dtValidade', $value->format('Y-m-d'));
                        }
                        break;
                }
            }
        }
    }
}