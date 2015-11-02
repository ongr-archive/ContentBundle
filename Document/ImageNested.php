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
 * Nested used for documents which require ImageNested standard fields.
 *
 * @ES\Nested
 */
class ImageNested
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
     * @ES\Property(name="title", type="string", options={"index"="no"})
     */
    private $title;

    /**
     * @var string
     *
     * @ES\Property(name="description", type="string", options={"index"="no"})
     */
    private $description;

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
