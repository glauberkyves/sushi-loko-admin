<?php
namespace Super\TransacaoBundle\Service;

use Base\BaseBundle\Entity\TbBonus;
use Base\BaseBundle\Entity\TbConfiguracaoFranquiaNivel;
use Base\BaseBundle\Entity\TbFranqueador;
use Base\BaseBundle\Entity\TbFranqueadorUsuario;
use Base\BaseBundle\Entity\TbUsuario;
use Base\CrudBundle\Service\CrudService;

class Bonus extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbBonus';

    public function setBonus(TbFranqueadorUsuario $idFranqueadorUsuario, $nuPontos = 0)
    {
        $nivelOld = $this->getNivel($idFranqueadorUsuario, $this->getBonus($idFranqueadorUsuario));

        $entity = new TbBonus();
        $entity->setIdFranqueadorUsuario($idFranqueadorUsuario);
        $entity->setNuBonus($nuPontos);
        $entity->setStAtivo(true);
        $entity->setStVencido(false);
        $entity->setDtCadastro(new \DateTime());

        try {
            $this->persist($entity);

            $nivel = $this->getNivel($idFranqueadorUsuario, $this->getBonus($idFranqueadorUsuario));

            if ($nivelOld->getNoNivel() != $nivel->getNoNivel()) {
                $this->sePontoNivelAtingido($idFranqueadorUsuario, $nivel);
            }

        } catch (\Exception $exp) {
            throw new \Exception('Erro ao inserir bônus.');
        }
    }

    public function getBonus(TbFranqueadorUsuario $idFranqueadorUsuario)
    {
        return $this->getRepository()->getBonus($idFranqueadorUsuario);
    }

    public function getNivel(TbFranqueadorUsuario $idFranqueadorUsuario)
    {
        $nivel        = false;
        $bonusUsuairo = $this->getBonus($idFranqueadorUsuario);

        foreach ($idFranqueadorUsuario->getIdFranqueador()->getIdConfiguracaoFranquiaNivel() as $value) {
            if ($bonusUsuairo >= $value->getNuQuantidadePontosNecessaio()) {
                $nivel = $value;
            }
        }

        return $nivel;
    }

    public function sePontoNivelAtingido(TbFranqueadorUsuario $idFranqueadorUsuario, TbConfiguracaoFranquiaNivel $nivel)
    {
        $entity = new TbBonus();
        $entity->setIdFranqueadorUsuario($idFranqueadorUsuario);
        $entity->setNuBonus($nivel->getNuQuantidadePontosPorAtingir());
        $entity->setStAtivo(true);
        $entity->setStVencido(false);
        $entity->setDtCadastro(new \DateTime());

        $this->persist($entity);
    }

    public function getPontosExtra(TbFranqueadorUsuario $idFranqueadorUsuario, $nuValor = 0.0)
    {
        $nivel = $this->getNivel($idFranqueadorUsuario);

        return ($nuValor / 100) * $nivel->getNuPorcentagemPontosExtra();
    }

    public function getBonusCreditar(TbFranqueadorUsuario $idFranqueadorUsuario, $nuValor = 0.0)
    {
        return round($nuValor * $idFranqueadorUsuario->getIdFranqueador()->getNuPontosTransacao());
    }
}