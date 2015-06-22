<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class AbstractRepository extends EntityRepository
{
    public function getResultGrid(Request $request)
    {
        $query = $this->fetchGrid($request);

        if ($query instanceof QueryBuilder) {
            $this->addWhere($query, $request);
            $this->addOrderBy($query, $request);

            return $query
                ->getQuery()
                ->getArrayResult();
        }
    }

    public function fetchGrid(Request $request)
    {
        return $this
            ->createQueryBuilder('e');
    }

    public function addWhere(QueryBuilder $query, Request $request)
    {
        $expr = new Expr();
        foreach ($request->query->all() as $key => $value) {
            if ($value != '') {
                $typeColumn = $this->getTypeColumn($query, $key);

                switch ($typeColumn) {
                    case 'string':
                        $query->andWhere($expr->like("e.{$key}", $expr->literal('%' . $value . '%')));
                        break;

                    case 'integer':
                        $query->andWhere($expr->eq("e.{$key}", $value));
                        break;

                }
            }
        }
    }

    /**
     * @todo
     * @param QueryBuilder $query
     * @param Request $request @
     */
    public function addOrderBy(QueryBuilder $query, Request $request)
    {
//        $column = $request->get('mDataProp_' . $request->get('iSortCol_0'));
//        $order  = $request->get('sSortDir_0');
//
//        $columnOrder = $this->getCurrentColumn($query, $column);
//
//        if ($query instanceof QueryBuilder) {
//            $query->addOrderBy($columnOrder, $order);
//        }
    }

    protected function getTypeColumn(QueryBuilder $query, $column)
    {
        $metadata = $this->getEntityManager()->getClassMetadata(current($query->getRootEntities()));

        return $metadata->getTypeOfColumn($column);
    }

    /**
     * Monta combo com campos do Tipo Pessoa
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

        $className  = $this->getClassName();
        $metadata   = $this->getEntityManager()->getClassMetadata($this->_entityName);
        $fieldNames = $metadata->getFieldNames();

        $getIdCodigo    = 'get' . ucfirst($fieldNames[0]);
        $getNoDescricao = 'get' . ucfirst($fieldNames[1]);

        foreach ($result as $item) {
            $itens[$item->{$getIdCodigo}()] = $item->{$getNoDescricao}();
        }

        return $itens;
    }
} 