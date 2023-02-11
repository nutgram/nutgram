<?php

namespace SergiX44\Nutgram\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('nutgram');

        $treeBuilder->getRootNode()
            ->children()
            ->arrayNode('nutgram')
            ->children()
            ->scalarNode('token')->end()
            ->booleanNode('safe_mode')->end()
            ->end()
            ->end() // nutgram
            ->end();

        return $treeBuilder;
    }
}
