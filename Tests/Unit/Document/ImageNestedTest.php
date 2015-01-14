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

use ONGR\ContentBundle\Document\ImageNested;

/**
 * Provides tests for imageNested document.
 */
class ImageNestedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testImageNested().
     *
     * @return array
     */
    public function imageNestedDataProvider()
    {
        $data = [
            [
                [
                    'url' => 'http://ongr.io/images/ongr_tools_logo.jpg',
                    'title' => null,
                    'description' => 'My imagesNested description.',
                ],
            ],
            [
                [
                    'url' => 'http://ongr.io/images/ongr_tools_logo2.jpg',
                    'title' => 'My Title 2',
                    'description' => 'My imagesNested description 2!',
                ],
            ],
        ];

        return $data;
    }

    /**
     * Tests imageNested.
     *
     * @param array $data
     *
     * @dataProvider imageNestedDataProvider()
     */
    public function testImageNested(array $data)
    {
        /** @var ImageNested $imagesNested */
        $imagesNested = $this->getMock('ONGR\ContentBundle\Document\ImageNested', null);
        $imagesNested->setUrl($data['url']);
        $this->assertEquals($data['url'], $imagesNested->getUrl());

        $imagesNested->setTitle($data['title']);
        $this->assertEquals($data['title'], $imagesNested->getTitle());

        $imagesNested->setDescription($data['description']);
        $this->assertEquals($data['description'], $imagesNested->getDescription());
    }
}
