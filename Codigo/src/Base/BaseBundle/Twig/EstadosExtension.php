<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 30/01/15
 * Time: 10:34
 */

namespace Base\BaseBundle\Twig;


use Base\BaseBundle\Service\Estado;
use Symfony\Component\DependencyInjection\Container;

class EstadosExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('estados', array($this, 'getEstados')),
        );
    }

    public function getName()
    {
        return 'estados_extension';
    }

    public function getEstados()
    {
        $arrEstado = Estado::getEstados();

        $html = '<select id="estado" name="estado" class="form-control">';

        foreach ($arrEstado as $estado) {
            $html .= "<option value=\"{$estado['idEstado']}\"";

            if ($this->container->get('session')->get('idEstado') == $estado['idEstado']) {
                $html .= ' selected="selected" ';
            }

            $html .= ">{$estado['noEstado']}</option>";
        }

        $html .= '</select>';

        return $html;
    }

}