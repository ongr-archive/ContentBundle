<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Unit\DependencyInjection;

use ONGR\ContentBundle\DependencyInjection\ONGRContentExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ONGRContentExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testLoad().
     *
     * @return array
     */
    public function getTestLoadData()
    {
        $config = [
            'ongr_content' => [
                'es' => [
                    'repositories' => [
                        'product' => 'es.manager.default.sample',
                        'content' => 'es.manager.default.content',
                        'category' => 'es.manager.category',
                    ],
                ],
            ],
        ];

        return [
            // Case #1.
            [
                'ongr_content.es.repositories',
                $config,
                [
                    'product' => 'es.manager.default.sample',
                    'content' => 'es.manager.default.content',
                    'category' => 'es.manager.category',
                ],
            ],
            // Case #2 Tests default value.
            ['ongr_content.snippet.render_strategy', $config, 'esi'],
            // Case #3.
            [
                'ongr_content.snippet.render_strategy',
                array_replace_recursive(
                    $config,
                    [
                        'ongr_content' => [
                            'snippet' => [
                                'render_strategy' => 'foo',
                            ],
                        ],
                    ]
                ),
                'foo',
            ],
        ];
    }

    /**
     * Tests load method.
     *
     * @param string $parameterName
     * @param array  $config
     * @param string $parameterValue
     *
     * @dataProvider getTestLoadData
     */
    public function testLoad($parameterName, $config, $parameterValue)
    {
        $container = new ContainerBuilder();
        $extension = new ONGRContentExtension();
        $extension->load($config, $container);

        $this->assertTrue($container->hasParameter($parameterName));
        $this->assertEquals($parameterValue, $container->getParameter($parameterName));
    }
}
