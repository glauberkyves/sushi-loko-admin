<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 06/07/2015
 * Time: 16:55
 */

namespace Base\BaseBundle\Repository;

use Base\BaseBundle\Entity\AbstractEntity;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class FranqueadorRepository extends AbstractRepository
{
    public function fetchGrid(Request $request)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('e.idFranqueador, e.noRazaoSocial, e.stAtivo')
            ->addSelect('(' .
                $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('COUNT(f1.idFranquia)')
                    ->from('Base\BaseBundle\Entity\TbFranquia', 'f1')
                    ->where($expr->eq('f1.idFranqueador', 'e.idFranqueador'))
                    ->getQuery()
                    ->getDQL()
                . ') totalFranquia'
            )
            ->from('Base\BaseBundle\Entity\TbFranqueador', 'e')
            ->innerJoin('e.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->addOrderBy('e.idFranqueador', 'desc');
    }

    public function selectLocalidade()
    {
        $arrLocalidade = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('a.idFranqueador, e.noLatitude, e.noLongitude')
            ->from('BaseBaseBundle:TbFranqueador', 'a')
            ->innerJoin('a.idEndereco', 'e')
            ->getQuery()
            ->getArrayResult();

        return $arrLocalidade;
    }

    public function findCidades($idFranqueador = null)
    {
        $arrCidades = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('m.idMunicipio, m.noMunicipio')
            ->from('BaseBaseBundle:TbFranquia', 'ff')
            ->innerJoin('ff.idEndereco', 'e')
            ->innerJoin('e.idMunicipio', 'm')
            ->innerJoin('ff.idFranqueador', 'f')
            ->where('f.idFranqueador = :idFranqueador')
            ->andWhere('ff.stAtivo = :stAtivo')
            ->andWhere('f.stAtivo = :stAtivo')
            ->groupBy('m.idMunicipio')
            ->setParameter('stAtivo', true)
            ->setParameter('idFranqueador', $idFranqueador)
            ->getQuery()
            ->getArrayResult();

        return $arrCidades;
    }

    public function findFranquiasByMunicipio($idFranqueador = null, $idMunicipio = null)
    {
        $arrFranquia = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('ff.idFranquia, ff.noFranquia, e.noLatitude, e.noLongitude, e.noEnderecoAmigavel')
            ->from('BaseBaseBundle:TbFranquia', 'ff')
            ->innerJoin('ff.idEndereco', 'e')
            ->innerJoin('e.idMunicipio', 'm')
            ->innerJoin('ff.idFranqueador', 'f')
            ->where('f.idFranqueador = :idFranqueador')
            ->andWhere('m.idMunicipio = :idMunicipio')
            ->andWhere('ff.stAtivo = :stAtivo')
            ->andWhere('f.stAtivo = :stAtivo')
            ->setParameter('stAtivo', true)
            ->setParameter('idFranqueador', $idFranqueador)
            ->setParameter('idMunicipio', $idMunicipio)
            ->getQuery()
            ->getArrayResult();

        return $arrFranquia;
    }

    public function findFranquiasByDistancia($idFranqueador = null, $noLatitude = 0, $noLongitude = 0)
    {
        $arrFranquia = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select("ff.idFranquia, ff.noFranquia, e.noLatitude, e.noLongitude, e.noEnderecoAmigavel,
                GEO(:noLatitude, :noLongitude, e.noLatitude, e.noLongitude) AS nuDistancia")
            ->from('BaseBaseBundle:TbFranquia', 'ff')
            ->innerJoin('ff.idEndereco', 'e')
            ->innerJoin('ff.idFranqueador', 'f')
            ->where('f.idFranqueador = :idFranqueador')
            ->andWhere('ff.stAtivo = :stAtivo')
            ->andWhere('f.stAtivo = :stAtivo')
            ->having('nuDistancia <= :nuDistancia')
            ->orderBy('nuDistancia', 'ASC')
            ->setParameter('stAtivo', true)
            ->setParameter('idFranqueador', $idFranqueador)
            ->setParameter('noLatitude', $noLatitude)
            ->setParameter('noLongitude', $noLongitude)
            ->setParameter('nuDistancia', 50)
            ->getQuery()
            ->getArrayResult();

        return $arrFranquia;
    }
}