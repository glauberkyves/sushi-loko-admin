<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 08/07/2015
 * Time: 15:20
 */

namespace Base\BaseBundle\Repository;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class FranquiaRepository extends AbstractRepository
{
    public function fetchGrid(Request $request)
    {
        $query = $this->createQueryBuilder('f');

        $query
            ->select('f.idFranquia, f.noFranquia, u.idUsuario, f.stAtivo')
            ->innerJoin('f.idUsuario', 'u');

            if($idFranqueador = $request->query->get('idFranqueador'))
            {
                $query
                    ->where('f.idFranqueador = :idFranqueador')
                    ->setParameter('idFranqueador', $idFranqueador);
            }

        return $query;
    }

    public function addWhere(QueryBuilder $query, Request $request)
    {
        $expr = new Expr();
        foreach ($request->query->all() as $key => $value) {
            if ($value != '') {
                $typeColumn = $this->getTypeColumn($query, $key);
                switch ($typeColumn) {
                    case 'string':
                        $query->andWhere($expr->like("f.{$key}", $expr->literal('%' . $value . '%')));
                        break;
                    case 'integer':
                        $query->andWhere($expr->eq("f.{$key}", $value));
                        break;
                    default:
                        break;
                }
            }
        }
    }
}