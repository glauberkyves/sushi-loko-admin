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

class CardapioRepository extends AbstractRepository
{
    public function fetchGrid(Request $request)
    {
        $idFranqueador = $request->query->get('idFranqueador', 0);

        return $this
            ->createQueryBuilder('c')
            ->select('c.idCardapio, c.noCardapio')
            ->where('c.idFranqueador = :idFranqueador')
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
                        $query->andWhere($expr->like("c.{$key}", $expr->literal('%' . $value . '%')));
                        break;
                    case 'integer':
                        $query->andWhere($expr->eq("c.{$key}", $value));
                        break;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * @override
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array The objects.
     * @return array
     */
    public function getComboDefault(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null)
    {
        $itens  = array();
        $result = $this->findBy($criteria, $orderBy, $limit, $offset);

        foreach ($result as $item) {
            $itens[$item->getIdCardapio()] = $item->getNoCardapioSuper();
        }

        return $itens;
    }
}