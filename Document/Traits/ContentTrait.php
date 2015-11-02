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
 * Trait used for documents which require Content standard fields.
 *
 * @deprecated Will be removed in stable version. Use AbstractContentDocument instead.
 */
trait ContentTrait
{
    /**
     * @var string
     *
     * @ES\Property(type="string", name="slug", options={"index"="not_analyzed"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="title", options={"index"="not_analyzed"})
     */
    private $title;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="content")
     */
    private $content;

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
