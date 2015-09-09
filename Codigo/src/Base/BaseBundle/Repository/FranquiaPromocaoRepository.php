<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 08/09/2015
 * Time: 18:33
 */

namespace Base\BaseBundle\Repository;

class FranquiaPromocaoRepository extends AbstractRepository
{
    public function getByIdFranqueador($idPromocao = 0, $idFranqueador = 0)
    {
        $query = $this
            ->createQueryBuilder('fp')
            ->select('ff.noFranquia')
            ->innerJoin('fp.idFranquia', 'ff')
            ->innerJoin('ff.idFranqueador', 'f')
            ->where('f.idFranqueador = :idFranqueador')
            ->andWhere('fp.idPromocao = :idPromocao')
            ->setParameter('idPromocao', $idPromocao)
            ->setParameter('idFranqueador', $idFranqueador)
            ->getQuery()
            ->getResult();

        return ($query) ? $query[0] : null;
    }
}