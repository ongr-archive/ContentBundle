<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from app/config files.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ongr_content');

        $rootNode
            ->children()
                ->arrayNode('es')
                    ->isRequired()
                    ->children()
                        ->arrayNode('repositories')
                            ->children()
                                ->scalarNode('product')->isRequired()->end()
                                ->scalarNode('content')->isRequired()->end()
                                ->scalarNode('category')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('category_root_id')
                    ->defaultValue('root_id')
                ->end()
                ->arrayNode('snippet')
                    ->cannotBeOverwritten()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('render_strategy')
                            ->defaultValue('esi')
                            ->info('Default template render strategy')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
