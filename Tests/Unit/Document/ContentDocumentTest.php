<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Unit\Document;

use ONGR\ContentBundle\Document\AbstractContentDocument;

/**
 * Provides tests for content document.
 */
class ContentDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testContentDocument().
     *
     * @return array
     */
    public function contentDocumentDataProvider()
    {
        $data = [
            [
                [
                    'slug' => 'my slug',
                    'title' => null,
                    'content' => 'My content content.',
                ],
            ],
            [
                [
                    'slug' => 'my slug 2',
                    'title' => 'My Title 2',
                    'content' => 'My content content 2!',
                ],
            ],
        ];

        return $data;
    }

    /**
     * Tests content document.
     *
     * @param array $data
     *
     * @dataProvider contentDocumentDataProvider()
     */
    public function testContentDocument(array $data)
    {
        /** @var AbstractContentDocument $content */
        $content = $this->getMockForAbstractClass('ONGR\ContentBundle\Document\AbstractContentDocument');
        $content->setSlug($data['slug']);
        $this->assertEquals($data['slug'], $content->getSlug());

        $content->setTitle($data['title']);
        $this->assertEquals($data['title'], $content->getTitle());

        $content->setContent($data['content']);
        $this->assertEquals($data['content'], $content->getContent());
    }
}
