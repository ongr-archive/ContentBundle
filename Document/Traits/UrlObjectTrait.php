<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Document\Traits;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Trait used for documents which require UrlObject standard fields.
 *
 * @deprecated Will be removed in stable version. Use UrlObject instead.
 */
trait UrlObjectTrait
{
    /**
     * @var string
     *
     * @ES\Property(name="url", type="string")
     */
    private $url;

    /**
     * @var string
     *
     * @ES\Property(name="key", type="string", options={"index"="no"})
     */
    private $urlKey;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $urlKey
     */
    public function setUrlKey($urlKey)
    {
        $this->urlKey = $urlKey;
    }

    /**
     * @return string
     */
    public function getUrlKey()
    {
        return $this->urlKey;
    }
}
