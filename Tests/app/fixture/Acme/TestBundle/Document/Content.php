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
use ONGR\RouterBundle\Document\SeoAwareTrait;

/**
 * Dummy content document.
 *
 * @ES\Document(type="content")
 */
class Content implements DocumentInterface
{
    use DocumentTrait;
    use SeoAwareTrait;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="slug", index="not_analyzed")
     */
    public $slug;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="title", index="not_analyzed")
     */
    public $title;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="short_description", index="not_analyzed")
     */
    public $shortDescription;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="left")
     */
    public $left;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="right")
     */
    public $right;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="parent_id", boost=1.0)
     */
    public $parentId;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="root_id", boost=1.0, index="not_analyzed")
     */
    public $rootId;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="sort")
     */
    public $sort;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="folder", index="not_analyzed")
     */
    public $folder;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="content", boost=2.0)
     */
    public $content;

    /**
     * @var bool
     *
     * @ES\Property(type="boolean", name="hidden")
     */
    public $hidden;

    /**
     * @var bool
     */
    public $selected;

    /**
     * Assigns multiple fields from array, just for test.
     *
     * @param array $data
     */
    public function assign($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
