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

use ONGR\ContentBundle\Document\Traits\CdnObjectTrait;

/**
 * Provides tests for cdn object.
 */
class CdnObjectTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testCdnTrait().
     *
     * @return array
     */
    public function cdnTraitDataProvider()
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
     * Tests cnd trait.
     *
     * @param array $data
     *
     * @dataProvider cdnTraitDataProvider()
     */
    public function testCdnTrait(array $data)
    {
        /** @var CdnObjectTrait $cdn */
        $cdn = $this->getMockForTrait('ONGR\\ContentBundle\\Document\\Traits\\CdnObjectTrait');
        $cdn->setCdnUrl($data['cdn_url']);
        $this->assertEquals($data['cdn_url'], $cdn->getCdnUrl());
    }
}
