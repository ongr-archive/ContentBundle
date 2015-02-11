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

use ONGR\ContentBundle\Service\ContentService;
use ONGR\ElasticsearchBundle\Test\AbstractElasticsearchTestCase;

class ContentServiceTest extends AbstractElasticsearchTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getDataArray()
    {
        return [
            'default' => [
                'content' => [
                    [
                        '_id' => 1,
                        'slug' => 'foo',
                    ],
                    [
                        '_id' => 2,
                        'slug' => 'baz',
                    ],
                    [
                        '_id' => 3,
                        'slug' => 'awsome',
                    ],
                ],
            ],
        ];
    }

    /**
     * Test if content service can retrieve document by slug.
     */
    public function testGetDocumentBySlug()
    {
        /** @var ContentService $contentService */
        $contentService = $this->getContainer()->get('ongr_content.content_service');
        $document = $contentService->getDocumentBySlug('baz');

        $this->assertEquals(2, $document->getId(), 'Expected document with Id of 2.');
    }
}
