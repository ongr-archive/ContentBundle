<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * AppKernel for tests.
 */
class AppKernel extends Kernel
{
    /**
     * Registering bundles.
     *
     * @return array
     */
    public function registerBundles()
    {
        return [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new ONGR\ElasticsearchBundle\ONGRElasticsearchBundle(),
            new ONGR\RouterBundle\ONGRRouterBundle(),
            new ONGR\ContentBundle\ONGRContentBundle(),

            // For testing document loading.
            new \ONGR\ContentBundle\Tests\app\fixture\Acme\TestBundle\AcmeTestBundle(),
        ];
    }

    /**
     * Container configuration.
     *
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
