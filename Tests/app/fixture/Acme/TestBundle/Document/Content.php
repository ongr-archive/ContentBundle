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

use ONGR\ContentBundle\Document\AbstractContentDocument;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Dummy content document.
 *
 * @ES\Document(type="content")
 */
class Content extends AbstractContentDocument
{
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
    private $hidden;

    /**
     * @var bool
     */
    private $selected;

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
        return $this->hidden;
    }

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->isHidden();
    }

    /**
     * @param bool $state
     */
    public function setHidden($state)
    {
        $this->hidden = $state;
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
        return $this->selected;
    }

    /**
     * @return bool
     */
    public function getSelected()
    {
        return $this->isSelected();
    }

    /**
     * @param bool $state
     */
    public function setSelected($state)
    {
        $this->selected = $state;
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
