<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 30/01/15
 * Time: 10:34
 */

namespace Base\BaseBundle\Twig;


use Super\AnuncioBundle\Service\TipoAnuncio;
use Symfony\Component\DependencyInjection\Container;

class TipoAnuncioExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('tipoAnuncio', array($this, 'getTipoAnuncio')),
        );
    }

    public function getName()
    {
        return 'tipo_anuncio_extension';
    }

    public function getTipoAnuncio()
    {
        $arrTipoAnuncio = $this->container->get('service.tipo_anuncio')->findAll(
            array(),
            array(
                'noTipoAnuncio' => 'asc'
            )
        );

        $html = '<select id="tipo-anuncio" name="tipo-anuncio" class="form-control">';
        $html .= '<option value="">Todos os tipos</option>';

        foreach ($arrTipoAnuncio as $anuncio) {
            if ($anuncio->getIdTipoAnuncio() == TipoAnuncio::VENDA) {
                $html .= "<option value=\"{$anuncio->getIdTipoAnuncio()}\" selected=\"selected\">{$anuncio->getNoTipoAnuncio()}</option>";
            } else {
                $html .= "<option value=\"{$anuncio->getIdTipoAnuncio()}\">{$anuncio->getNoTipoAnuncio()}</option>";
            }
        }

        $html .= '</select>';

        return $html;
    }

}