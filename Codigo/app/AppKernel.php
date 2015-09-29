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
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Liuggio\ExcelBundle\LiuggioExcelBundle(),

            new Base\BaseBundle\BaseBaseBundle(),
            new Base\CrudBundle\BaseCrudBundle(),

            new Super\SecurityBundle\SuperSecurityBundle(),
            new Super\BaseBundle\SuperBaseBundle(),

            new SiteBundle\SiteBundle(),
            new Super\PromocaoBundle\SuperPromocaoBundle(),
            new Super\EnqueteBundle\SuperEnqueteBundle(),

            new Super\FranqueadorBundle\SuperFranqueadorBundle(),
            new Super\OperadorBundle\SuperOperadorBundle(),
            new Super\UsuarioBundle\SuperUsuarioBundle(),
            new Super\FranquiaBundle\SuperFranquiaBundle(),
            new Super\CardapioBundle\SuperCardapioBundle(),
            new Super\FeedbackBundle\SuperFeedbackBundle(),
            new Super\MobileBundle\SuperMobileBundle(),
            new Super\TransacaoBundle\SuperTransacaoBundle(),
            new Super\TemplateBundle\SuperTemplateBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new AppBundle\AppBundle();
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
