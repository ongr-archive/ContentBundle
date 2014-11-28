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

use ONGR\ContentBundle\Document\Traits\ImagesNestedTrait;

/**
 * Provides tests for imagesNested document.
 */
class ImagesNestedTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testImagesNestedTrait().
     *
     * @return array
     */
    public function imagesNestedTraitDataProvider()
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
     * Tests imagesNested trait.
     *
     * @param array $data
     *
     * @dataProvider imagesNestedTraitDataProvider()
     */
    public function testImagesNestedTrait(array $data)
    {
        /** @var ImagesNestedTrait $imagesNested */
        $imagesNested = $this->getMockForTrait('ONGR\\ContentBundle\\Document\\Traits\\ImagesNestedTrait');
        $imagesNested->setUrl($data['url']);
        $this->assertEquals($data['url'], $imagesNested->getUrl());

        $imagesNested->setTitle($data['title']);
        $this->assertEquals($data['title'], $imagesNested->getTitle());

        $imagesNested->setDescription($data['description']);
        $this->assertEquals($data['description'], $imagesNested->getDescription());
    }
}
