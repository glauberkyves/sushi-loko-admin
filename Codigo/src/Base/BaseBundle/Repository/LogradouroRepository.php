<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 06/07/2015
 * Time: 16:45
 */

namespace Base\BaseBundle\Repository;

class LogradouroRepository extends AbstractRepository
{
    public function getDadosCep($nuCep)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('e.idEstado, e.noEstado, m.idMunicipio, m.noMunicipio, b.idBairro, b.noBairro, l.noLogradouro')
            ->from('BaseBaseBundle:TbLogradouro', 'l')
            ->innerJoin('l.idBairro', 'b')
            ->innerJoin('b.idMunicipio', 'm')
            ->innerJoin('m.idEstado', 'e')
            ->where('l.nuCep = :nuCep')
            ->setParameter('nuCep', $nuCep, 'integer')
            ->getQuery()
            ->getArrayResult();
    }
}