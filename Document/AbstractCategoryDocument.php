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
use ONGR\RouterBundle\Document\SeoAwareTrait;
use ONGR\ElasticsearchBundle\Document\AbstractDocument;

/**
 * Category document with standard fields.
 *
 * @ES\Document(create=false)
 */
abstract class AbstractCategoryDocument extends AbstractDocument
{
    use SeoAwareTrait;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="sort")
     */
    protected $sort;

    /**
     * @var bool
     *
     * @ES\Property(type="boolean", name="active")
     */
    protected $active;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="parent_id")
     */
    protected $parentId;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="level")
     */
    protected $level;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="title", options={"index"="not_analyzed"})
     */
    protected $title;

    /**
     * @var bool
     *
     * @ES\Property(type="boolean", name="is_hidden")
     */
    protected $hidden;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="left")
     */
    protected $left;

    /**
     * @var int
     *
     * @ES\Property(type="integer", name="right")
     */
    protected $right;

    /**
     * @var bool
     */
    protected $expanded;

    /**
     * @var bool
     */
    protected $current;

    /**
     * @var array
     */
    private $breadcrumbs;

    /**
     * @var AbstractCategoryDocument[]|\Iterator
     */
    protected $children;

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
                if (!$child->isHidden()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param AbstractCategoryDocument[]|\Iterator $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return AbstractCategoryDocument[]|\Iterator
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
     * @param AbstractCategoryDocument|\Iterator $value
     * @param string                             $key
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
     * @param AbstractCategoryDocument|\Iterator $value
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
     * @return bool
     */
    public function getActive()
    {
        return $this->isActive();
    }

    /**
     * @param bool $state
     */
    public function setActive($state)
    {
        $this->active = $state;
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
        return $this->isCurrent();
    }

    /**
     * @return bool
     */
    public function isCurrent()
    {
        return $this->current;
    }

    /**
     * @param bool $state
     */
    public function setExpanded($state)
    {
        $this->expanded = $state;
    }

    /**
     * @return bool
     */
    public function getExpanded()
    {
        return $this->isExpanded();
    }

    /**
     * @return bool
     */
    public function isExpanded()
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
}
