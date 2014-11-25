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

/**
 * Trait used for documents which require Category standard fields.
 *
 * @package ONGR\ContentBundle\Document
 */
trait CategoryTrait
{
    /**
     * @var string
     *
     * @ES\Property(type="string", name="root_id")
     */
    public $rootId;

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
     * @ES\Property(type="string", name="sort")
     */
    public $sort;

    /**
     * @var bool
     *
     * @ES\Property(type="boolean", name="active")
     */
    public $active;

    /**
     * @var bool
     *
     * @ES\Property(type="boolean", name="hidden")
     */
    public $hidden;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="parent_id")
     */
    public $parentId;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="level")
     */
    private $level;

    /**
     * @var bool
     */
    private $expanded;

    /**
     * @var bool
     */
    private $current;

    /**
     * @var array
     */
    public $breadcrumbs;

    /**
     * @var array
     */
    private $children;

    /**
     * Tests if category has any children.
     *
     * @return bool
     */
    public function hasChildren()
    {
        return is_array($this->children) && count($this->children);
    }

    /**
     * Tests if category has any visible children.
     *
     * @return bool
     */
    public function hasVisibleChildren()
    {
        if (is_array($this->children) && count($this->children)) {
            foreach ($this->children as $child) {
                if (!$child->hidden) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param array $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getChild($key)
    {
        return $this->children[$key];
    }

    /**
     * If key is null value is put to the end.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setChild($key, $value)
    {
        if (empty($key)) {
            $this->children[] = $value;
        } else {
            $this->children[$key] = $value;
        }
    }

    /**
     * @param bool $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @return bool
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param bool $expanded
     */
    public function setExpanded($expanded)
    {
        $this->expanded = $expanded;
    }

    /**
     * @return bool
     */
    public function getExpanded()
    {
        return $this->expanded;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return string
     */
    public function getGetParentId()
    {
        return $this->level;
    }
}
