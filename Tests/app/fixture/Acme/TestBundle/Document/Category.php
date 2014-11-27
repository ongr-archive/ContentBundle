<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\app\fixture\Acme\TestBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchBundle\Document\DocumentTrait;
use ONGR\ContentBundle\Document\Traits\CategoryTrait;
use ONGR\RouterBundle\Document\SeoAwareTrait;

/**
 * Dummy category document.
 *
 * @ES\Document(type="category")
 */
class Category implements DocumentInterface
{
    use DocumentTrait;
    use CategoryTrait;
    use SeoAwareTrait;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="left")
     */
    private $left;

    /**
     * @var bool
     *
     * @ES\Property(type="boolean", name="hidden")
     */
    private $hidden;

    /**
     * @return int
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @param int $left
     */
    public function setLeft($left)
    {
        $this->left = $left;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
}
