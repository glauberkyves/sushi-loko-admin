<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 22/01/15
 * Time: 18:14
 */

namespace SiteBundle\Service;

use Base\BaseBundle\Entity\AbstractEntity;
use Base\CrudBundle\Service\CrudService;

class Galeria extends CrudService
{
    protected $entityName = 'Base\BaseBundle\Entity\TbGaleria';


    public function save(AbstractEntity $entity = null)
    {
        ini_set('max_execution_time', -1);

        $idImovel = $this->getRequest()->request->get('idImovel');
        $request  = $this->getRequest();

        if ($request->getSession()->has('token-galeria') && $idImovel) {
            $rootDir      = $request->server->get('DOCUMENT_ROOT');
            $tokenGaleria = $request->getSession()->get('token-galeria');
            $path         = '/galeria/' . $tokenGaleria . '/';

            $entityImovel = $this->getService('service.imovel')->find($idImovel);
            $criteria = array(
                'idImovel' => $idImovel,
                'idUsuario' => $this->getUser()->getIdUsuario()
            );

            foreach ($this->findBy($criteria) as $entityOld) {
                $this->remove($entityOld);
            }

            foreach (new \DirectoryIterator($rootDir . $path) as $key => $fileInfo) {
                if (!$fileInfo->isDot() && !$fileInfo->isDir()) {
                    $image     = $rootDir . $path . $fileInfo->getFilename();
                    $imageTumb = $rootDir . $path . 'tumb/' . $fileInfo->getFilename();
                    $this
                        ->getService('image.handling')
                        ->open($image)
                        ->resize(1000)
                        ->save($image);

                    # tumb
                    $this
                        ->getService('image.handling')
                        ->open($image)
                        ->resize(216)
                        ->save($imageTumb);

                    $entity = $this->newEntity();
                    $entity->setIdImovel($entityImovel);
                    $entity->setIdUsuario($this->getUser());
                    $entity->setNoUrl($path . $fileInfo->getFilename());
                    $entity->setNoUrlThumbnail($path . 'tumb/' . $fileInfo->getFilename());
                    $entity->setDtCadastro(new \DateTime());

                    $this->persist($entity);
                }
            }
        }
    }
}