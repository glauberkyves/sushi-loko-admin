<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 28/08/2015
 * Time: 14:43
 */

namespace Base\BaseBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Symfony\Component\HttpFoundation\Response;
use Super\TransacaoBundle\Service\TipoTransacao;
use Base\BaseBundle\Entity\TbTransacao;

class Pesquisa extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\Pesquisa';

    /**
     * Adicionar pontos ou bonus a lista de usuarios
     * @param array $arrUsuarios
     * @return array
     */
    public function addPontosBonus(array $arrUsuarios = array())
    {
        $response   = array('valido' => false);
        $request    = $this->getRequest()->query;
        $srvUsuario = $this->getService('service.usuario');

        $nuPontos = $request->get('addPontos');
        $nuBonus  = floatval(str_replace(',', '.', str_replace('.', '', $request->get('addBonus'))));

        if ($nuPontos || $nuBonus) {
            if ($arrUsuarios) {
                foreach ($arrUsuarios as $usuario) {

                    $entityUsuario = $srvUsuario->find($usuario['idUsuario']);

                    if ($nuBonus > 0) {
                        $this->saveTransacao(
                            $entityUsuario,
                            $nuBonus
                        );
                    }

                    if ($nuPontos > 0) {

                    }
                }
                $response['valido']   = true;
                $response['mensagem'] = 'Operação realizada com sucesso!';
            } else {
                $response['mensagem'] = 'Nenhum registro encontrado!';
            }
        } else {
            $response['mensagem'] = 'Informe a quantidade de pontos ou bônus para acrescentar!';
        }

        return $response;
    }

    /**
     * Exportar lista de usuarios da pesquisa em formato csv
     * @param array $arrUsuarios
     * @return mixed
     */
    public function exportar(Response $response)
    {
        $date = date("d-m-Y_H-i-s");
        $filename = "usuarios_".$date.".csv";

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Description', 'Submissions Export');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    public function saveTransacao($idUsuario = null, $nuValor = 0)
    {
        $entity = new TbTransacao();

        $idFranqueador = $this->getService('service.franqueador')->find(56);

        $idTipoTransacao = $this->getService('service.tipo_transacao')->find(TipoTransacao::CREDITO_AVULSO);

        $nuValor = str_replace(".", "", $nuValor);
        $nuValor = str_replace(",", ".", $nuValor);

        $entity->setIdOperador($this->getUser());
        $entity->setIdArquivo(null);
        $entity->setIdTipoTransacao($idTipoTransacao);
        $entity->setIdUsuario($idUsuario);
        $entity->setIdFranquia(null);
        $entity->setIdFranqueador($idFranqueador);
        $entity->setNuValor($nuValor);
        $entity->setDtCadastro(new \DateTime());
        $entity->setStAtivo(true);

        $this->persist($entity);
    }

    /**
     * Buscar operador aritimetico
     * @param string $operador
     * @return string
     */
    public static function getOperador($operador = 'igual')
    {
        switch ($operador) {
            case 'igual': return '=';
            case 'maior': return '>';
            case 'menor': return '<';
            default:      return '=';
        }
    }

    /**
     * Buscar periodo em string, usuado em $datetime->modify()
     * @param string $periodo
     * @return string
     */
    public static function getPeriodo($periodo = 'd')
    {
        switch ($periodo) {
            case 'd': return 'days';
            case 'm': return 'months';
            case 'a': return 'years';
            default:  return 'days';
        }
    }

    /**
     * Combo de sexo
     * @return array
     */
    public static function getComboSexo()
    {
        return array(
            'm' => 'Masculino',
            'f' => 'Feminino',
            'u' => 'Todos'
        );
    }

    /**
     * Combo de periodo
     * @return array
     */
    public static function getComboPeriodo()
    {
        return array(
            'd' => 'Dias',
            'm' => 'Meses'
        );
    }

    /**
     * Combo de operadores aritimeticos
     * @return array
     */
    public static function getComboOperador()
    {
        return array(
            'igual' => 'Igual',
            'maior' => 'Maior',
            'menor' => 'Menor'
        );
    }

    /**
     * Sobrescrever retorno para grid
     * @param array $itens
     * @param bool|false $addOptions
     * @return array
     */
    public function parserItens(array $itens = array(), $addOptions = false)
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                switch (true) {
                    case $keyIten == 'nuCreditoTotal':
                        $nuBonus = $iten - $itens[$key]['nuDebitoTotal'];
                        $itens[$key]['nuBonus'] = sprintf("R$ %s", number_format($nuBonus, 2, ',', '.'));
                        break;
                    case $keyIten == 'sgSexo':
                        $itens[$key]['sgSexo'] = $iten == 'M' ? 'Masculino' : $iten == 'F' ? 'Feminino' : 'Não informado';
                        break;
                }
            }
        }

        return parent::parserItens($itens, $addOptions);
    }
}