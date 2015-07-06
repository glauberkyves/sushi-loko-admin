<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 06/07/2015
 * Time: 13:00
 */

namespace Base\BaseBundle\Repository;

class PessoaFisicaRepository extends AbstractRepository
{
    public function getByNoEmail($noEmail = '')
    {
        $qb = $this->createQueryBuilder('pf');

        return $qb
            ->leftJoin('pf.idPessoa', 'p')
            ->where($qb->expr()->like('pf.noEmail', ':noEmail'))
            ->setParameter('noEmail', '%' . $noEmail . '%', 'string')
            ->getQuery()
            ->getResult();
    }
}