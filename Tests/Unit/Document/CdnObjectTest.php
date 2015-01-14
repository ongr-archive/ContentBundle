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

use ONGR\ContentBundle\Document\CdnObject;

/**
 * Provides tests for cdn object.
 */
class CdnObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testCdnObject().
     *
     * @return array
     */
    public function cdnObjectDataProvider()
    {
        $data = [
            [
                [
                    'cdn_url' => 'http://ongr.io',
                ],
            ],
            [
                [
                    'cdn_url' => 'http://ongr.io/use-case/',
                ],
            ],
        ];

        return $data;
    }

    /**
     * Tests cnd object.
     *
     * @param array $data
     *
     * @dataProvider cdnObjectDataProvider()
     */
    public function testCdnObject(array $data)
    {
        /** @var CdnObject $cdn */
        $cdn = $this->getMock('ONGR\ContentBundle\Document\CdnObject', null);
        $cdn->setCdnUrl($data['cdn_url']);
        $this->assertEquals($data['cdn_url'], $cdn->getCdnUrl());
    }
}
