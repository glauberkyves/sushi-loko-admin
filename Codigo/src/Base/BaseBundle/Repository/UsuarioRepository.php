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
    public function usuariosCadastradosSemana()
    {
        $data = new \DateTime();

        return $this
            ->createQueryBuilder('u')
            ->select('COUNT(u.idUsuario) as total, DAY(u.dtCadastro) as dtCadastro')
            ->where('u.dtCadastro >= :dtCadastro')
            ->groupBy("dtCadastro")
            ->orderBy('dtCadastro', 'ASC')
            ->setParameter('dtCadastro', $data->modify('-7 day')->format("Y-m-d"))
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

            return $result ? current($result) : array();
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

    public function getByCpfSenha($cpf = null, $senha = null)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->where('pf.nuCpf = :nuCpf')
            ->andWhere('u.noSenha = :noSenha')
            ->andWhere('u.stAtivo = :stAtivo')
            ->setParameter('nuCpf', preg_replace("/[^\d]/", "", $cpf))
            ->setParameter('noSenha', $senha)
            ->setParameter('stAtivo', true)
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

        return $this
            ->createQueryBuilder('e');
    }
}