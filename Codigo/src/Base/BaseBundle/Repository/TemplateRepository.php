<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 06/07/2015
 * Time: 17:08
 */

namespace Base\BaseBundle\Repository;


use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\Request;

class TemplateRepository extends AbstractRepository
{

    public function fetchGrid(Request $request)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('e.idTemplateEmail, e.stAtivo, tt.noTipoTemplate')
            ->from('Base\BaseBundle\Entity\TbTemplateEmail', 'e')
            ->innerJoin('e.idTipoTemplate', 'tt')
            ->where($expr->eq('e.idFranqueador', $request->get('idFranqueador')));
    }

    public function combo($idFranqueador)
    {
        $expr = new Expr();

        $arrTipoEmail = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('t.idTipoTemplate')
            ->from('Base\BaseBundle\Entity\TbTipoTemplate', 't')
            ->innerJoin('Base\BaseBundle\Entity\TbTemplateEmail', 'te', 'WITH', 't.idTipoTemplate = te.idTipoTemplate')
            ->innerJoin('te.idFranqueador', 'f')
            ->where($expr->eq('f.idFranqueador', $idFranqueador))
            ->getQuery()
            ->getResult();

        $arrIds = array();
        foreach ($arrTipoEmail as $value) {
            $arrIds[] = $value['idTipoTemplate'];
        }

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('t.idTipoTemplate, t.noTipoTemplate')
            ->from('Base\BaseBundle\Entity\TbTipoTemplate', 't');

        if ($arrIds) {
            $query->where($expr->notIn('t.idTipoTemplate', $arrIds));
        }

        $result = $query
            ->getQuery()
            ->getResult();

        $itens  = array();
        foreach ($result as $item) {
            $itens[$item['idTipoTemplate']] = $item['noTipoTemplate'];
        }

        return $itens;
    }
}