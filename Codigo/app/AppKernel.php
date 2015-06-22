<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function init()
    {
        date_default_timezone_set('America/Sao_Paulo');
        parent::init();
    }

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new GlauberKyves\Bundle\ZendFormTwigBundle\ZendFormTwigBundle(),
            new Gregwar\ImageBundle\GregwarImageBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

            new Base\BaseBundle\BaseBaseBundle(),
            new Base\CrudBundle\BaseCrudBundle(),

            new Super\SecurityBundle\SuperSecurityBundle(),
            new Super\UsuarioBundle\SuperUsuarioBundle(),
            new Super\ImovelBundle\SuperImovelBundle(),
            new Super\BaseBundle\SuperBaseBundle(),
            new Super\AnuncioBundle\SuperAnuncioBundle(),

            new SiteBundle\SiteBundle(),
            new Super\ServicoBundle\SuperServicoBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
