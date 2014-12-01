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

use ONGR\ContentBundle\Document\Traits\ContentTrait;
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
    use ContentTrait;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="short_description", index="not_analyzed")
     */
    private $shortDescription;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="left")
     */
    private $left;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="right")
     */
    private $right;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="parent_id", boost=1.0)
     */
    private $parentId;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="root_id", boost=1.0, index="not_analyzed")
     */
    private $rootId;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="sort")
     */
    private $sort;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="folder", index="not_analyzed")
     */
    private $folder;

    /**
     * @var bool
     *
     * @ES\Property(type="boolean", name="is_hidden")
     */
    private $isHidden;

    /**
     * @var bool
     */
    private $isSelected;

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

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->isHidden;
    }

    /**
     * @return bool
     */
    public function getIsHidden()
    {
        return $this->isHidden();
    }

    /**
     * @param bool $state
     */
    public function setIsHidden($state)
    {
        $this->isHidden = $state;
    }

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
     * @return string
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param string $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return int
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param int $right
     */
    public function setRight($right)
    {
        $this->right = $right;
    }

    /**
     * @return string
     */
    public function getRootId()
    {
        return $this->rootId;
    }

    /**
     * @param string $rootId
     */
    public function setRootId($rootId)
    {
        $this->rootId = $rootId;
    }

    /**
     * @return bool
     */
    public function isSelected()
    {
        return $this->isSelected;
    }

    /**
     * @return bool
     */
    public function getIsSelected()
    {
        return $this->isSelected();
    }

    /**
     * @param bool $state
     */
    public function setIsSelected($state)
    {
        $this->isSelected = $state;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }
}
