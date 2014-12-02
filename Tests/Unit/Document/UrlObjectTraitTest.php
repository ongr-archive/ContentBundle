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

use ONGR\ContentBundle\Document\Traits\UrlObjectTrait;

/**
 * Provides tests for url object.
 */
class UrlObjectTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testUrlTrait().
     *
     * @return array
     */
    public function urlTraitDataProvider()
    {
        $data = [
            [
                [
                    'url' => 'http://ongr.io',
                    'key' => 'key1',
                ],
            ],
            [
                [
                    'url' => 'http://ongr.io/use-case/',
                    'key' => 'key2',
                ],
            ],
        ];

        return $data;
    }

    /**
     * Tests url trait.
     *
     * @param array $data
     *
     * @dataProvider urlTraitDataProvider()
     */
    public function testUrlTrait(array $data)
    {
        /** @var UrlObjectTrait $url */
        $url = $this->getMockForTrait('ONGR\\ContentBundle\\Document\\Traits\\UrlObjectTrait');
        $url->setUrl($data['url']);
        $this->assertEquals($data['url'], $url->getUrl());

        $url->setUrlKey($data['key']);
        $this->assertEquals($data['key'], $url->getUrlKey());
    }
}
