<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Object used for documents which require CdnObject standard fields.
 *
 * @ES\Object
 */
abstract class AbstractCdnObject
{
    /**
     * @var string
     *
     * @ES\Property(name="cdn_url", type="string")
     */
    private $cdnUrl;

    /**
     * @param string $cdnUrl
     */
    public function setCdnUrl($cdnUrl)
    {
        $this->cdnUrl = $cdnUrl;
    }

    /**
     * @return string
     */
    public function getCdnUrl()
    {
        return $this->cdnUrl;
    }
}
