<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 14/09/2015
 * Time: 15:47
 */

namespace Base\BaseBundle\Repository;

class RequisacaoTransacaoRepository extends AbstractRepository
{
    public function getUltimaTransacao($idUsuario = 0)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('rt')
            ->from('Base\BaseBundle\Entity\TbRequisacaoTransacao', 'rt')
            ->where('rt.idUsuario = :idUsuario')
            ->andWhere('rt.stAtivo = 1')
            ->andWhere('rt.stUtilizado = 1')
            ->orderBy('rt.idRequisacaoTransacao', 'DESC')
            ->setMaxResults(1)
            ->setParameter('idUsuario', $idUsuario)
            ->getQuery()
            ->getResult();

        return ($query) ? $query[0] : null;
    }
}