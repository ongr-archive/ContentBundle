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

class ONGRContentExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests load method.
     */
    public function testLoad()
    {
        $mockDefinition = $this->getMock('Symfony\Component\DependencyInjection\Definition');
        $mockDefinition->expects($this->exactly(4))
            ->method('addArgument');

        $mockContainerBuilder = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $mockContainerBuilder->expects($this->exactly(3))
            ->method('getDefinition')
            ->will($this->returnValue($mockDefinition));

        $ext = new ONGRContentExtension();
        $ext->load(
            [
                'ongr_content' => [
                    'es' => [
                        'repositories' => [
                            'product' => 'es.manager.default.sample',
                            'content' => 'es.manager.default.content',
                            'category' => 'es.manager.category',
                        ],
                    ],
                ],
            ],
            $mockContainerBuilder
        );
    }
}
