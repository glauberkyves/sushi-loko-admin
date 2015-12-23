<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 08/09/2015
 * Time: 18:33
 */

namespace Base\BaseBundle\Repository;

class FranquiaCardapioRepository extends AbstractRepository
{
    public function getByIdFranqueador($idCardapio = 0, $idFranqueador = 0)
    {
        $query = $this
            ->createQueryBuilder('fp')
            ->select('ff.noFranquia')
            ->innerJoin('fp.idFranquia', 'ff')
            ->innerJoin('ff.idFranqueador', 'f')
            ->where('f.idFranqueador = :idFranqueador')
            ->andWhere('fp.idCardapio = :idCardapio')
            ->setParameter('idCardapio', $idCardapio)
            ->setParameter('idFranqueador', $idFranqueador)
            ->getQuery()
            ->getResult();

        return ($query) ? $query[0] : null;
    }
}