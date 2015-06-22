<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 23/01/15
 * Time: 13:51
 */

namespace SiteBundle\Service;

use Base\BaseBundle\Service\AbstractService;
use Base\CrudBundle\Service\CrudService;

class Agenda extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbAgenda';

    public function  cancelarAgenda($id)
    {

        $horarioAgendado = $this->getRepository()->findOneByIdAgendaHorario($id);
        $this->remove($horarioAgendado);

        $enridade = $this->getService('service.agendarhorario')->find($id);
        $enridade->setStatus(1);
        $this->persist($enridade);

        return array("status"=>"ok","mensagem"=>"Cancelado com Sucesso.");

    }

    public function agendarNovamente($id,$id2)
    {

        $agendarNovamente1  = $this->getService('service.agendarhorario')->find($id2);
        $agendarNovamente1->setStatus(1);
        $this->persist($agendarNovamente1);

        $agendarNovamente2  = $this->getService('service.agendarhorario')->find($id);
        $agendarNovamente2->setStatus(0);
        $this->persist($agendarNovamente2);

        $agendarNovamente  = $this->getRepository()->findOneByIdAgendaHorario($id2);
        $agendarNovamente->setIdAgendaHorario($agendarNovamente2);
        $this->persist($agendarNovamente);
        return array("status"=>"ok","mensagem"=>"Alterado com Sucesso.");
    }
}