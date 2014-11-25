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
    private $rootId;

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
     * @ES\Property(type="string", name="sort")
     */
    private $sort;

    /**
     * @var bool
     *
     * @ES\Property(type="boolean", name="active")
     */
    private $active;

    /**
     * @var bool
     *
     * @ES\Property(type="boolean", name="hidden")
     */
    private $hidden;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="parent_id")
     */
    private $parentId;

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
    private $breadcrumbs;

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
     * @param mixed  $value
     * @param string $key
     */
    public function setChild($value, $key = null)
    {
        if (empty($key)) {
            $this->children[] = $value;
        } else {
            $this->children[$key] = $value;
        }
    }

    /**
     * Adds child to the end of children array.
     *
     * @param mixed $value
     */
    public function addChild($value)
    {
        $this->setChild($value);
    }

    /**
     * Tests if category has any breadcrumbs.
     *
     * @return bool
     */
    public function hasBreadcrumbs()
    {
        return is_array($this->breadcrumbs) && count($this->breadcrumbs);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getBreadcrumb($key)
    {
        return $this->breadcrumbs[$key];
    }

    /**
     * If key is null value is put to the end.
     *
     * @param mixed  $value
     * @param string $key
     */
    public function setBreadcrumb($value, $key = null)
    {
        if (empty($key)) {
            $this->breadcrumbs[] = $value;
        } else {
            $this->breadcrumbs[$key] = $value;
        }
    }

    /**
     * Add breadcrumb to end of breadcrumbs array.
     *
     * @param mixed $value
     */
    public function addBreadcrumb($value)
    {
        $this->setBreadcrumb($value);
    }

    /**
     * @return array
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

    /**
     * @param array $breadcrumbs
     */
    public function setBreadcrumbs($breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
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
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param string $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isHidden()
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

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
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
    public function getParentId()
    {
        return $this->parentId;
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
     * @return string
     */
    public function getGetParentId()
    {
        return $this->level;
    }
}
