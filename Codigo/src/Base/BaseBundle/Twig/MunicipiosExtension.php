<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 30/01/15
 * Time: 10:34
 */

namespace Base\BaseBundle\Twig;


use Symfony\Component\DependencyInjection\Container;

class MunicipiosExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('municipios', array($this, 'getMunicipios')),
        );
    }

    public function getName()
    {
        return 'municipios_extension';
    }

    public function getMunicipios($idEstado)
    {
        $arrEstado = $this->container->get('service.municipio')->findByIdEstado(
            $idEstado,
            array(
                'noMunicipio' => 'asc'
            )
        );

        $html = '<select id="municipio" name="municipio" class="form-control">';

        foreach ($arrEstado as $municipio) {
            $html .= "<option value=\"{$municipio->getIdMunicipio()}\">{$municipio->getNoMunicipio()}</option>";
        }

        $html .= '</select>';

        return $html;
    }

}