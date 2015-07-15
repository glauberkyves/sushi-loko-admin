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
use Symfony\Component\Validator\Constraints\DateTime;

class UsuarioRepository extends AbstractRepository
{

    public function usuariosCadastradosSemana()
    {
        $data = new \DateTime();
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('count(u.idUsuario) as total, u.dtCadastro')
            ->from('Base\BaseBundle\Entity\TbUsuario', 'u')
            ->where('u.dtCadastro >= :dtcadastro')
            ->groupBy("u.dtCadastro")
            ->setParameter('dtcadastro',$data->modify('-7 day')->format("Y-m-d"))
            ->getQuery()->getResult();
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
            ->innerJoin('u.rlUsuarioPerfil', 'up')
            ->innerJoin('up.idPerfil', 'per')
            ->innerJoin('u.idPessoa', 'p')
            ->innerJoin('p.idPessoaFisica', 'pf')
            ->where($expr->eq('pf.nuCpf', $request->request->getDigits('nuCpf')))
            ->andWhere($expr->eq('u.stAtivo', true))
            ->andWhere($expr->eq('per.sgPerfil', $expr->literal(Perfil::SG_OPERADOR)))
            ->getQuery()
            ->getResult();
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
}