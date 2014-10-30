<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Functional\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContentServiceTest extends WebTestCase
{
    /**
     * Test if content service can be created.
     */
    public function testGetContentService()
    {
        $container = self::createClient()->getContainer();
        $this->assertTrue($container->has('ongr_content.content_service'));
        $this->assertInstanceOf(
            'ONGR\\ContentBundle\\Service\\ContentService',
            $container->get('ongr_content.content_service')
        );
    }
}
