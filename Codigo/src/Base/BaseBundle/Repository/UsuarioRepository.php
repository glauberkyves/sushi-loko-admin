<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

use Doctrine\ORM\Query\Expr;
use Super\UsuarioBundle\Service\Perfil;
use Symfony\Component\HttpFoundation\Request;

class UsuarioRepository extends AbstractRepository
{
    public function getUsuariosCadastrados($nuMes = 0, $idFranqueador = 0)
    {
        $query = $this
            ->createQueryBuilder('u')
            ->select('COUNT(u.idUsuario) as total, MONTH(u.dtCadastro) nuMes, DAY(u.dtCadastro) dtCadastro')
            ->innerJoin('u.idFranqueadorUsuario', 'f')
            ->having('nuMes = :nuMes');

        if ($idFranqueador) {
            $query
                ->andWhere('f.idFranqueador = :idFranqueador')
                ->setParameter('idFranqueador', $idFranqueador);
        }

        return $query
            ->orderBy('dtCadastro', 'ASC')
            ->groupBy('dtCadastro')
            ->setParameter('nuMes', $nuMes)
            ->getQuery()
            ->getResult();
    }

    public function getLocalidades($idFranqueador = 0)
    {
        return $this
            ->createQueryBuilder('u')
            ->select('u.idUsuario, u.noLatitude, u.noLongitude, p.noPessoa')
            ->innerJoin('u.idFranqueadorUsuario', 'f')
            ->innerJoin('u.idPessoa', 'p')
            ->where('f.idFranqueador = :idFranqueador')
            ->setParameter('idFranqueador', $idFranqueador)
            ->getQuery()
            ->getResult();
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        if (isset($criteria['nuCpf']) && $criteria['nuCpf']) {
            $expr   = new Expr();
            $result = $this
                ->getEntityManager()
                ->createQueryBuilder()
                ->select('u')
                ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
                ->innerJoin('u.idPessoa', 'p')
                ->innerJoin('p.idPessoaFisica', 'pf')
                ->where($expr->eq('pf.nuCpf', preg_replace("/[^\d]/", "", $criteria['nuCpf'])))
                ->andWhere($expr->eq('u.stAtivo', true))
                ->getQuery()
                ->getResult();

            if($result){
                $entity = current($result);
                switch (true) {
                    case $entity->getIdFranqueador():
                        return $entity;
                        break;
                    case $entity->getIdFranquia() && $entity->getIdFranquia()->getStAtivo():
                        return $entity;
                        break;
                    case $entity->getIdOperadorFranquia():
                        return $entity;
                        break;
                    case $entity->getIdOperadorFranqueador():
                        return $entity;
                        break;
                }
            }

            return array();
        }

        return parent::findOneBy($criteria, $orderBy);
    }

    public function findOperador(Request $request)
    {
        $expr = new Expr();

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->where($expr->eq('pf.nuCpf', $expr->literal($request->request->getDigits('nuCpf'))))
            ->orWhere($expr->eq('pf.noEmail', $expr->literal($request->request->get('noEmail'))))
            ->getQuery()
            ->getResult();
    }

    public function findCpf(Request $request)
    {
        $expr = new Expr();

        $result = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->where($expr->eq('pf.nuCpf', $expr->literal($request->query->getDigits('nuCpf'))))
            ->getQuery()
            ->getResult();

        return $result ? false : true;
    }

    public function getByCpfEmailSenha($nuCpfNoEmail = null, $senha = null, $idFranqueador = null)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->innerJoin('u.idFranqueadorUsuario', 'f')
            ->where('pf.nuCpf = :nuCpf')
            ->orWhere('pf.noEmail = :noEmail')
            ->andWhere('u.noSenha = :noSenha')
            ->andWhere('u.stAtivo = :stAtivo')
            ->andWhere('f.idFranqueador = :idFranqueador')
            ->setParameter('nuCpf', preg_replace("/[^\d]/", "", $nuCpfNoEmail))
            ->setParameter('noEmail', $nuCpfNoEmail)
            ->setParameter('noSenha', $senha)
            ->setParameter('stAtivo', true)
            ->setParameter('idFranqueador', $idFranqueador)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function fetchGrid(Request $request)
    {
        $expr = new Expr();

        if ($request->get('_route') == 'super_operador_index') {
            return $this
                ->getEntityManager()
                ->createQueryBuilder()
                ->select('p.noPessoa, pf.noEmail, u.idUsuario, u.stAtivo ')
                ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
                ->innerJoin('u.idPessoa', 'p')
                ->innerJoin('p.idPessoaFisica', 'pf')
                ->innerJoin('Base\BaseBundle\Entity\TbFranquiaOperador', 'fo', 'WITH', 'fo.idOperador = u.idUsuario')
                ->where($expr->eq('fo.idFranquia', $request->get('idFranquia')));
        }

        return $this->createQueryBuilder('e');
    }
}