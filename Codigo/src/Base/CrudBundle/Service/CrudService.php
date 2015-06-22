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

    public function parserItens(array $itens = array())
    {
        foreach ($itens as $key => $value) {
            foreach ($value as $keyIten => $iten) {
                switch (true) {
                    case $iten instanceof \DateTime:
                        $itens[$key][$keyIten] = $iten->format('d/m/Y');
                        break;
                    case $keyIten == 'stAtivo':
                        $itens[$key][$keyIten] = $iten == 1 ? 'Ativo' : 'Inativo';
                        break;
                }
            }
        }
        return $itens;
    }

    public function uploadFile($folder, $fileInput = null, $imageOnly = true)
    {
        $arrFilesNames = array();
        if ($imageOnly) {
            //verifica todos os arquivos antes de subir para o servidor
            //para evitar inconsistencias no meio do processo
            foreach ($this->getRequest()->files->all() as $key => $file) {
                if ($file) {
                    if ($fileInput && $fileInput == $key) {
                        // Verifica se o mime-type do arquivo é de uma imagem
                        if (!preg_match("/(bmp|gif|jpg|jpeg|png)/i", $file->guessExtension())) {
                            $this->addMessage(sprintf('O arquivo %s não é uma imagem válida.', $file->getClientOriginalName()), 'error');
                            return null;
                        }
                    }
                }
            }
        }
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


    public function getComboDefault(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null)
    {
        return array('' => 'Selecione') + $this->getRepository()->getComboDefault($criteria, $orderBy, $limit, $offset);
    }
}