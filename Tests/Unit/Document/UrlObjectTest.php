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

use ONGR\ContentBundle\Document\UrlObject;

/**
 * Provides tests for url object.
 */
class UrlObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testUrlObject().
     *
     * @return array
     */
    public function urlObjectDataProvider()
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
     * Tests url object.
     *
     * @param array $data
     *
     * @dataProvider urlObjectDataProvider()
     */
    public function testUrlObject(array $data)
    {
        /** @var UrlObject $url */
        $url = $this->getMock('ONGR\ContentBundle\Document\UrlObject', null);
        $url->setUrl($data['url']);
        $this->assertEquals($data['url'], $url->getUrl());

        $url->setUrlKey($data['key']);
        $this->assertEquals($data['key'], $url->getUrlKey());
    }
}
