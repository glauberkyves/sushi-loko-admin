<?php

namespace Super\EnqueteBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Base\BaseBundle\Entity\AbstractEntity;
use Base\BaseBundle\Service\Data;

class RelatorioEnquete extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbEnquete';

    public function porcentagem_xn($porcentagem, $total)
    {
        return ($total / $porcentagem) * 100;
    }

    public function parserItens(array $itens = array(), $addOptions = true)
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {

                $id = $itens[$key]['idEnquete'];
                $participantes = $this->getService('service.enquete')->participanteEnquete($id);
                $respostas = $this->getService('service.enquete')->respostaEnquete($id);

                switch (true) {
                    case $iten instanceof \DateTime:
                        $itens[$key][$keyIten] = $iten->format('d/m/Y');
                        break;
                    case $keyIten == 'stAtivo':
                        $itens[$key][$keyIten] = $iten == 1 ? 'NÃO' : 'SIM';
                        break;
                }

                if ($addOptions) {
                    $itens[$key]['opcoes'] = $this->container->get('templating')->render(
                        $this->optionsRouteName(),
                        array('data' => (object)$value)
                    );
                }

                $itens[$key]['participantes'] = '<span class="label label-inverse btn-sm"><i class="fa fa-user"></i> '.$participantes['total'].'</span>';

                isset($respostas[0]) ? $itens[$key]['respostas1'] = '<span class="badge bg-primary">' . $this->porcentagem_xn($respostas[0]["respostas"], $respostas[0]["total"]) . "%" . '</span>' : $itens[$key]['respostas1'] = '<span class="badge bg-primary">0%</span>';
                isset($respostas[1]) ? $itens[$key]['respostas2'] = '<span class="badge bg-warning">' . $this->porcentagem_xn($respostas[0]["respostas"], $respostas[1]["total"]) . "%" . '</span>' : $itens[$key]['respostas2'] = '<span class="badge bg-warning">0%</span>';
                isset($respostas[2]) ? $itens[$key]['respostas3'] = '<span class="badge bg-important">' . $this->porcentagem_xn($respostas[0]["respostas"], $respostas[2]["total"]) . "%" . '</span>' : $itens[$key]['respostas3'] = '<span class="badge bg-important">0%</span>';

            }
        }

        return $itens;
    }
}