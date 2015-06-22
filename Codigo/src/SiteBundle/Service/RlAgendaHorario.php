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
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class RlAgendaHorario extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbAgendarHorario';

    public function listagem($id)
    {
        $listar = $this->getRepository()->findByIdAnuncio($id);
        return $listar;
    }

    public function obterIdUsuario($id)
    {
        $listar = $this->getRepository()->findByIdUsuario($id);
        return $listar;
    }

    public function listagemDeHorario($id)
    {
        $listar = $this->getRepository()->find($id);
        $idUsuario          = $this->getUser();

        if(!$idUsuario)
        {
            return array("status"=>"erro","mensagem"=>"É necessario fazer login.");
        }

        $enridade = $this->getService('service.agendar')->newEntity();

        $enridade->setIdUsuario($idUsuario);
        $enridade->setIdAgendaHorario($listar);
        $this->persist($enridade);

        $listar->setStatus(0);
        $this->persist($listar);
        return array("status"=>"ok","mensagem"=>"Agendado com sucesso.");
    }

    public function createAgenda()
    {
        $idAnuncio = $this->getRequest()->request->get("idAnuncio");
        $anuncio = $this->getService('service.anuncio')->find($idAnuncio);

        $data      = $this->getRequest()->request->get("dataAgenda");
        $hora      = $this->getRequest()->request->get("hora");
        $idUsuario = $this->getUser();
        $entidade = $this->getService('service.agendarhorario')->newEntity();

        $entidade->setIdUsuario($idUsuario);
        $entidade->setIdAnuncio($anuncio);
        $entidade->setStatus(1);
        $entidade->setHorario(new \DateTime("$data $hora"));
        $this->persist($entidade);
    }

    public function removerAgenda($id)
    {
        $listar = $this->getRepository()->find($id);
        $listar->setStRemovido(1);
        $this->persist($listar);
        return array("status"=>"ok","mensagem"=>"Removido com sucesso.");
    }
}