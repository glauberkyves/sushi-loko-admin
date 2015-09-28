<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

use Base\BaseBundle\Service\Data;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class FeedbackRepository extends AbstractRepository
{
    public function getRelatorio($id = 0, $idFranquia = null, $dtInicio = null)
    {
        $expr = new Expr();

        $query = $this
            ->createQueryBuilder('f')
            ->select('f.stAtivo, COUNT(DISTINCT fr.idUsuario) participantes')
            ->addSelect(
                '(' .
                $this
                    ->getEntityManager()
                    ->createQueryBuilder()
                    ->select('AVG(fr1.nuResposta)')
                    ->from('Base\BaseBundle\Entity\TbFeedbackQuestaoResposta', 'fr1')
                    ->innerJoin('fr1.idFeedbackQuestao', 'fq1')
                    ->innerJoin('fq1.idFeedback', 'f1')
                    ->where('f1.idFeedback = :idFeedback')
                    ->andWhere('fq1.nuPosicao = 1')
                    ->getQuery()
                    ->getDQL()
                . ') media1'
            )
            ->addSelect(
                '(' .
                $this
                    ->getEntityManager()
                    ->createQueryBuilder()
                    ->select('AVG(fr2.nuResposta)')
                    ->from('Base\BaseBundle\Entity\TbFeedbackQuestaoResposta', 'fr2')
                    ->innerJoin('fr2.idFeedbackQuestao', 'fq2')
                    ->innerJoin('fq2.idFeedback', 'f2')
                    ->where('f2.idFeedback = :idFeedback')
                    ->andWhere('fq2.nuPosicao = 2')
                    ->getQuery()
                    ->getDQL()
                . ') media2'
            )
            ->addSelect(
                '(' .
                $this
                    ->getEntityManager()
                    ->createQueryBuilder()
                    ->select('AVG(fr3.nuResposta)')
                    ->from('Base\BaseBundle\Entity\TbFeedbackQuestaoResposta', 'fr3')
                    ->innerJoin('fr3.idFeedbackQuestao', 'fq3')
                    ->innerJoin('fq3.idFeedback', 'f3')
                    ->where('f3.idFeedback = :idFeedback')
                    ->andWhere('fq3.nuPosicao = 3')
                    ->getQuery()
                    ->getDQL()
                . ') media3'
            )
            ->innerJoin('f.idFeedbackQuestao', 'fq')
            ->innerJoin('fq.idFeedbackQuestaoResposta', 'fr')
            ->innerJoin('fr.idFranquia', 'fra')
            ->where('f.idFeedback = :idFeedback')
            ->setParameter('idFeedback', $id, \PDO::PARAM_INT);

        if ($idFranquia) {
            $query->andWhere($expr->eq('fra.idFranquia', $idFranquia));
        }

        if ($dtInicio) {
            $query->andWhere($expr->gte("fr.dtCadastro", $expr->literal(Data::dateBr($dtInicio)->format('Y-m-d') . ' 00:00:00')));
        }

        $result = $query->getQuery()
            ->getArrayResult();

        return ($result) ? $result[0] : array();
    }

    public function getMensagens($id = 0, $idFranquia = null, $dtInicio = null)
    {
        $expr = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p.noPessoa, u.idUsuario, fr.dsResposta, fr.dtCadastro, fra.noFranquia, fr.nuResposta')
            ->from('Base\BaseBundle\Entity\TbFeedbackQuestaoResposta', 'fr')
            ->innerJoin('fr.idFeedbackQuestao', 'fq')
            ->innerJoin('fr.idFranquia', 'fra')
            ->innerJoin('fq.idFeedback', 'f')
            ->innerJoin('fr.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->where('f.idFeedback = :idFeedback')
            ->groupBy('fr.idUsuario')
            ->orderBy('fr.dtCadastro', 'ASC')
            ->setParameter('idFeedback', $id, \PDO::PARAM_INT);

        if ($idFranquia) {
            $query->andWhere($expr->eq('fra.idFranquia', $idFranquia));
        }

        if ($dtInicio) {
            $query->andWhere($expr->gte("fr.dtCadastro", $expr->literal(Data::dateBr($dtInicio)->format('Y-m-d') . ' 00:00:00')));
        }

        return $query->getQuery()
            ->getArrayResult();
    }

    public function getGrafico($id, $nuPosicao = 1, $idFranquia = null, $dtInicio = null)
    {
        $expr = new Expr();

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('AVG(fr.nuResposta) media, MONTH(fr.dtCadastro) dtMonth, fr.dtCadastro')
            ->from('Base\BaseBundle\Entity\TbFeedbackQuestaoResposta', 'fr')
            ->innerJoin('fr.idFeedbackQuestao', 'fq')
            ->innerJoin('fr.idFranquia', 'fra')
            ->innerJoin('fq.idFeedback', 'f')
            ->where('f.idFeedback = :idFeedback')
            ->andWhere('fq.nuPosicao = :nuPosicao')
            ->groupBy('dtMonth')
            ->orderBy('fr.dtCadastro', 'ASC')
            ->setParameter('idFeedback', $id, \PDO::PARAM_INT)
            ->setParameter('nuPosicao', $nuPosicao, \PDO::PARAM_INT);

        if ($idFranquia) {
            $query->andWhere($expr->eq('fra.idFranquia', $idFranquia));
        }

        if ($dtInicio) {
            $query->andWhere($expr->gte("fr.dtCadastro", $expr->literal(Data::dateBr($dtInicio)->format('Y-m-d') . ' 00:00:00')));
        }

        return $query->getQuery()
            ->getArrayResult();
    }

    public function fetchGrid(Request $request)
    {
        return $this
            ->createQueryBuilder('e')
            ->innerJoin('e.idFranqueador', 'ff')
            ->innerJoin('ff.idFranquia', 'f')
            ->groupBy('e.idFeedback');
    }

    public function addWhere(QueryBuilder $query, Request $request)
    {
        $expr = new Expr();
        foreach ($request->query->all() as $key => $value) {
            if ($value != '') {
                $typeColumn = $this->getTypeColumn($query, $key);

                switch ($typeColumn) {
                    case 'string':
                        $query->andWhere($expr->like("e.{$key}", $expr->literal('%' . $value . '%')));
                        break;

                    case 'integer':
                        $query->andWhere($expr->eq("e.{$key}", $value));
                        break;

                    case 'datetime':
                        $query->andWhere($expr->gte("e.{$key}", $expr->literal(Data::dateBr($value)->format('Y-m-d') . ' 00:00:00')));
                        break;

                    case null:
                        if ($key == 'idFranquia') {
                            $query->andWhere($expr->eq("f.{$key}", $value));
                        }
                        break;
                }
            }
        }
    }
}