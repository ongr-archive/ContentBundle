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

use ONGR\ContentBundle\Document\AbstractProductDocument;

/**
 * Provides tests for product document.
 */
class AbstractProductDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testProductDocument().
     *
     * @return array
     */
    public function productDocumentDataProvider()
    {
        $data = [
            [
                [
                    'title' => null,
                    'description' => 'My product description.',
                    'long_description' => 'My product long description.',
                    'sku' => 'qwertyuiop',
                    'price' => 2.34,
                ],
            ],
            [
                [
                    'title' => 'Title',
                    'description' => 'My product description2.',
                    'long_description' => 'My product long description2.',
                    'sku' => 'qwertyuiop2',
                    'price' => 4.34,
                ],
            ],
        ];

        return $data;
    }

    /**
     * Tests product document.
     *
     * @param array $data
     *
     * @dataProvider productDocumentDataProvider()
     */
    public function testProductDocument(array $data)
    {
        /** @var AbstractProductDocument $product */
        $product = $this->getMockForAbstractClass('ONGR\ContentBundle\Document\AbstractProductDocument');
        $product->setTitle($data['title']);
        $this->assertEquals($data['title'], $product->getTitle());

        $product->setDescription($data['description']);
        $this->assertEquals($data['description'], $product->getDescription());

        $product->setSku($data['sku']);
        $this->assertEquals($data['sku'], $product->getSku());

        $product->setLongDescription($data['long_description']);
        $this->assertEquals($data['long_description'], $product->getLongDescription());

        $product->setPrice($data['price']);
        $this->assertEquals($data['price'], $product->getPrice());
    }
}
