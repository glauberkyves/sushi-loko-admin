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
            ->innerJoin('e.idTipoTemplate','tt')
            ->where($expr->eq('e.idFranqueador', $request->get('idFranqueador')));
    }
}