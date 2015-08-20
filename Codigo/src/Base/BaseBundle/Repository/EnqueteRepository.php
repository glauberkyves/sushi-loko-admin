<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

use Base\BaseBundle\Entity\AbstractEntity;

class EnqueteRepository extends AbstractRepository
{
    public function participanteEnquete($idEnquete)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder('u')
            ->select('COUNT(u.idUsuario) as total')
            ->from('Base\BaseBundle\Entity\TbEnqueteRespostaUsuario', 'u')
            ->innerJoin('u.idEnqueteResposta', 'p')
            ->innerJoin('p.idEnquete', 'e')
            ->where('e.idEnquete = :idEnquete')
            ->setParameter('idEnquete', $idEnquete)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function respostaEnquete($idEnquete)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder('u')
            ->select('p.idResposta, COUNT(u.idUsuario) as total')
            ->addSelect('(' .
                $this
                    ->getEntityManager()
                    ->createQueryBuilder()
                    ->select('COUNT(r.idUsuario) as resposta ')
                    ->from('Base\BaseBundle\Entity\TbEnqueteRespostaUsuario', 'r')
                    ->innerJoin('r.idEnqueteResposta', 'rp')
                    ->innerJoin('rp.idEnquete', 're')
                    ->where('re.idEnquete = :idEnquete')
                    ->setParameter('idEnquete', $idEnquete)
                    ->setMaxResults(1)
                    ->setFirstResult(1)
                    ->getQuery()
                    ->getDQL()
                . ') respostas'
            )
            ->from('Base\BaseBundle\Entity\TbEnqueteRespostaUsuario', 'u')
            ->innerJoin('u.idEnqueteResposta', 'p')
            ->innerJoin('p.idEnquete', 'e')
            ->where('e.idEnquete = :idEnquete')
            ->groupBy('p.idResposta')
            ->orderBy('p.nuPosicao', 'asc')
            ->setParameter('idEnquete', $idEnquete)
            ->getQuery()
            ->getArrayResult();

    }
}