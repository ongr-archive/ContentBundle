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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages bundle configuration.
 */
class ONGRContentExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        // Inject manager and repository to services.
        $repositories = $config['es']['repositories'];

        $container->setParameter('ongr_content.es.repositories', $repositories);

        $contentService = $container->getDefinition('ongr_content.content_service');
        $contentService->addArgument(new Reference($repositories['content']));

        $twigExtension = $container->getDefinition('ongr_content.twig.content_extension');
        $twigExtension->addArgument(new Reference($repositories['content']));

        $categoryService = $container->getDefinition('ongr_content.category_service');
        $categoryService->addArgument(new Reference($repositories['category']));

        $container->setParameter('ongr_content.snippet.render_strategy', $config['snippet']['render_strategy']);
    }
}
