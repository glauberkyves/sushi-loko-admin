<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 20/01/15
 * Time: 16:25
 */

namespace Base\CrudBundle\Service;

use Base\BaseBundle\Service\AbstractService;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Base\BaseBundle\Service\Dominio;

class CrudService extends AbstractService
{
    public function getResultGrid(Request $request)
    {
        $result = $this->getRepository()->getResultGrid($request);

        $sEcho = $request->query->get('sEcho');
        $page  = $request->query->get('iDisplayStart', 1);
        $rows  = $request->query->get('iDisplayLength', 10);

        $paginator  = new Paginator();
        $pagination = $paginator->paginate($result, $page, $rows);

        $data                       = new \StdClass();
        $data->sEcho                = $sEcho;
        $data->iTotalRecords        = $page;
        $data->iTotalDisplayRecords = ceil($pagination->getTotalItemCount() / $rows);
        $data->records              = $pagination->getTotalItemCount();
        $data->aaData               = $this->parserItens($pagination->getItems());

        return (array)$data;
    }

    public function parserItens(array $itens = array(), $addOptions = true)
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                switch (true) {
                    case $iten instanceof \DateTime:
                        $itens[$key][$keyIten] = $iten->format('d/m/Y');
                        break;
                    case $keyIten == 'stAtivo':
                        switch($iten){
                            case Dominio::ATIVO:
                                $iten = 'Ativo';
                                break;
                            case Dominio::INATIVO:
                                $iten = 'Inativo';
                                break;
                            case Dominio::SUSPENSO:
                                $iten = 'Suspenso';
                                break;
                        }
                        $itens[$key][$keyIten] = $iten;
                        break;
                }
                if ($addOptions) {
                    $itens[$key]['opcoes'] = $this->container->get('templating')->render(
                        $this->optionsRouteName(),
                        array('data' => (object)$value)
                    );
                }
            }
        }

        return $itens;
    }

    /**
     * Retorna o nome do arquivo twig para renderizar
     *
     * @return mixed
     */
    public function optionsRouteName($templating = 'gridOptions.html.twig')
    {
        $explode    = explode('Controller', $this->getRequest()->attributes->get('_controller'));
        $bundle     = str_replace('\\', '', current($explode));
        $controller = str_replace('\\', '', next($explode));

        return "{$bundle}:{$controller}:{$templating}";
    }

    public function getComboDefault(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null)
    {
        return array('' => 'Selecione') + $this->getRepository()->getComboDefault($criteria, $orderBy, $limit, $offset);
    }

    public function uploadFile($folder, $fileInput = null)
    {
        $arrFilesNames = array();

        foreach ($this->getRequest()->files->all() as $key => $file) {
            if ($file) {
                $fileName = md5(uniqid() . microtime()) . '.' . $file->getClientOriginalExtension();
                $rootDir  = $this->getRequest()->server->get('DOCUMENT_ROOT');
                $path     = DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR;
                if ($fileInput && $fileInput == $key) {
                    $file->move($rootDir . $path, $fileName);
                    $this->getRequest()->files->remove($fileInput);
                    return str_replace('\\', '/', $path . $fileName);
                    break;
                }
                $file->move($rootDir . $path, $fileName);
                $arrFilesNames[] = str_replace('\\', '/', $path . $fileName);
            }
        }
        return $arrFilesNames;
    }
}