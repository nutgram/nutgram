<?php

namespace SergiX44\Nutgram\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class NutgramExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('nutgram.config', $config['config'] ?? []);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Config/'));
        $loader->load('services.yaml');
    }

    public function getAlias(): string
    {
        return 'nutgram';
    }
}
