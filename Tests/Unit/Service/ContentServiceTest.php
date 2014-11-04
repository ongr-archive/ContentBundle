<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Unit\Service;

use ONGR\ContentBundle\Service\ContentService;
use ONGR\ContentBundle\Tests\app\fixture\Acme\TestBundle\Document\Content;
use ONGR\ElasticsearchBundle\Test\ElasticsearchTestCase;

/**
 * Provides tests for content service.
 */
class ContentServiceTest extends ElasticsearchTestCase
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
                        'slug' => 'cat',
                        'content' => 'Some content',
                        'title' => 'Some title',
                    ],
                    [
                        '_id' => 2,
                        'slug' => 'cat2',
                        'content' => 'Some content',
                        'title' => 'Some title 2',
                    ],
                    [
                        '_id' => 3,
                        'slug' => 'dog',
                        'content' => 'Some content 2',
                        'title' => 'Some title 3',
                    ],
                ],
            ],
        ];
    }

    /**
     * Data provider for testGetDocumentBySlug.
     *
     * @return array
     */
    public function documentSlugProvider()
    {
        $data = [];

        // Case #0.
        $content = new Content();
        $content->assign(
            [
                '_id' => 1,
                'slug' => 'cat',
                'score' => 0.30685282,
                'content' => 'Some content',
                'title' => 'Some title',
            ]
        );
        $data[] = [
            'slug' => 'cat',
            'expected' => $content,
        ];

        // Case #1.
        $data[] = [
            'slug' => 'non-existing',
            'expected' => null,
        ];

        return $data;
    }

    /**
     * Tests GetDocumentBySlug.
     *
     * @param string $slug
     * @param mixed  $expected
     *
     * @dataProvider documentSlugProvider
     */
    public function testGetDocumentBySlug($slug, $expected)
    {
        $repository = $this->getManager()->getRepository('AcmeTestBundle:Content');
        $service = new ContentService($repository);
        $result = $service->getDocumentBySlug($slug);
        $this->assertEquals($expected, $result);
    }

    /**
     * Data provider for testGetDataForSnippet.
     *
     * @return array
     */
    public function dataForSnippetProvider()
    {
        $data = [];

        // Case #0.
        $content = new Content();
        $content->assign(
            [
                '_id' => 1,
                'slug' => 'cat',
                'score' => 0.30685282,
                'content' => 'Some content',
                'title' => 'Some title',
            ]
        );
        $data[] = [
            'slug' => 'cat',
            'expected' => [
                'content' => 'Some content',
                'title' => 'Some title',
                'document' => $content,
            ],
        ];

        // Case #1.
        $data[] = [
            'slug' => 'non-existing',
            'expected' => [
                'content' => '',
                'title' => null,
                'document' => null,
            ],
        ];

        return $data;
    }

    /**
     * Tests GetDocumentBySlug.
     *
     * @param string $slug
     * @param mixed  $expected
     *
     * @dataProvider dataForSnippetProvider
     */
    public function testGetDataForSnippet($slug, $expected)
    {
        $repository = $this->getManager()->getRepository('AcmeTestBundle:Content');
        $service = new ContentService($repository);
        $result = $service->getDataForSnippet($slug);
        $this->assertEquals($expected, $result);
    }
}
