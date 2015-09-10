<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 21/01/15
 * Time: 14:14
 */

namespace Base\BaseBundle\Repository;

class FeedbackRepository extends AbstractRepository
{
    public function getRelatorio($id = 0)
    {
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
            ->where('f.idFeedback = :idFeedback')
            ->setParameter('idFeedback', $id, \PDO::PARAM_INT)
            ->getQuery()
            ->getArrayResult();

        return ($query) ? $query[0] : array();
    }

    public function getMensagens($id = 0)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p.noPessoa, u.idUsuario, fr.dsResposta, fr.dtCadastro')
            ->from('Base\BaseBundle\Entity\TbFeedbackQuestaoResposta', 'fr')
            ->innerJoin('fr.idFeedbackQuestao', 'fq')
            ->innerJoin('fq.idFeedback', 'f')
            ->innerJoin('fr.idUsuario', 'u')
            ->innerJoin('u.idPessoa', 'p')
            ->where('f.idFeedback = :idFeedback')
            ->groupBy('fr.idUsuario')
            ->orderBy('fr.dtCadastro', 'ASC')
            ->setParameter('idFeedback', $id, \PDO::PARAM_INT)
            ->getQuery()
            ->getArrayResult();
    }

    public function getGrafico($id, $nuPosicao = 1)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('AVG(fr.nuResposta) media, MONTH(fr.dtCadastro) dtMonth, fr.dtCadastro')
            ->from('Base\BaseBundle\Entity\TbFeedbackQuestaoResposta', 'fr')
            ->innerJoin('fr.idFeedbackQuestao', 'fq')
            ->innerJoin('fq.idFeedback', 'f')
            ->where('f.idFeedback = :idFeedback')
            ->andWhere('fq.nuPosicao = :nuPosicao')
            ->groupBy('dtMonth')
            ->orderBy('fr.dtCadastro', 'ASC')
            ->setParameter('idFeedback', $id, \PDO::PARAM_INT)
            ->setParameter('nuPosicao', $nuPosicao, \PDO::PARAM_INT)
            ->getQuery()
            ->getArrayResult();
    }
}