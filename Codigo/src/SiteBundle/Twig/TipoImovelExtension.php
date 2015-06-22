<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 30/01/15
 * Time: 10:34
 */

namespace SiteBundle\Twig;


use Symfony\Component\DependencyInjection\Container;

class TipoImovelExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('tipoImovel', array($this, 'getTipoImovel')),
        );
    }

    public function getName()
    {
        return 'tipo_imovel_extension';
    }

    public function getTipoImovel()
    {
        $arrTipoImovel = $this->container->get('service.tipo_imovel')->findAll(
            array(),
            array(
                'noTipoImovel' => 'asc'
            )
        );

        $html = '<select id="tipo-imovel" name="tipo-imovel" class="form-control">';
        $html .= '<option value="">Todos os tipos</option>';

        foreach ($arrTipoImovel as $imovel) {
            $html .= "<option value=\"{$imovel->getIdTipoImovel()}\">{$imovel->getNoTipoImovel()}</option>";
        }

        $html .= '</select>';

        return $html;
    }

}