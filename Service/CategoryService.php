<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Service;

use ONGR\ContentBundle\Document\AbstractCategoryDocument;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchDSL\Query\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use ONGR\ElasticsearchBundle\Service\Repository;
use ONGR\ElasticsearchBundle\Result\DocumentIterator;

/**
 * Used to manipulate category trees and nodes.
 */
class CategoryService
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var string
     */
    private $rootId;

    /**
     * @var array
     */
    private $treeCache;

    /**
     * @var bool
     */
    private $loadHiddenCategories;

    /**
     * @var DocumentInterface
     */
    private $currentLeaf = null;

    /**
     * @var null|string
     */
    private $currentCategoryId = null;

    /**
     * @var int
     */
    private $limit = 1000;

    /**
     * @param Repository $repository
     * @param string     $rootId
     */
    public function __construct(Repository $repository, $rootId)
    {
        $this->repository = $repository;
        $this->rootId = $rootId;
    }

    /**
     * Builds a search query.
     *
     * @return Search
     */
    protected function buildQuery()
    {
        /** @var Search $search */
        $search = $this->repository->createSearch();
        $search->setSize($this->limit);
        $search->addSort(new FieldSort('left', FieldSort::ASC));
        $search->addQuery(new TermQuery('active', true), 'must');
        if (!$this->loadHiddenCategories) {
            $search->addQuery(new TermQuery('is_hidden', 0), 'must');
        }

        return $search;
    }

    /**
     * Builds a child node.
     *
     * @param AbstractCategoryDocument $node
     * @param \ArrayIterator           $references
     * @param int                      $maxLevel
     */
    private function buildChildNode($node, $references, $maxLevel)
    {
        if (isset($references[$node->getParentId()])) {
            $level = $references[$node->getParentId()]->getLevel() + 1;

            // Check if max level is not reached or not set at all.
            if ($maxLevel == 0 || $level <= $maxLevel) {
                $node->setLevel($level);
                $node->setParent($references[$node->getParentId()]);
                $references[$node->getParentId()]->setChild($node, $node->getId());
            }
        }
    }

    /**
     * Gets category by id.
     *
     * @param string $id Category ID.
     *
     * @return DocumentInterface
     */
    public function getCategory($id)
    {
        $category = $this->repository->find($id);

        return $category;
    }

    /**
     * Builds a root node.
     *
     * @param AbstractCategoryDocument $node
     * @param \ArrayIterator           $tree
     * @param int                      $level
     */
    private function buildRootNode($node, $tree, $level)
    {
        $node->setLevel($level);
        $tree[$node->getId()] = $node;
    }

    /**
     * Builds a node. Sets node parameters.
     *
     * @param AbstractCategoryDocument $node
     * @param \ArrayIterator           $references
     * @param \ArrayIterator           $tree
     * @param int                      $maxLevel
     */
    private function buildNode($node, $references, $tree, $maxLevel)
    {
        if ($node->getId() == $this->getCurrentCategoryId()) {
            $node->setCurrent(true);
            $this->currentLeaf = $node;
        }

        $references[$node->getId()] = $node;

        if ($node->getParentId() == $this->rootId) {
            $this->buildRootNode($node, $tree, 1);
        } else {
            $this->buildChildNode($node, $references, $maxLevel);
        }
    }

    /**
     * Expands nodes.
     *
     * @param \ArrayIterator $references
     */
    private function expandNodes($references)
    {
        $id = $this->getCurrentCategoryId();

        if ($id) {
            while (isset($references[$id])) {
                $references[$id]->setExpanded(true);
                $id = $references[$id]->getParentId();
            }
        }
    }

    /**
     * Builds nested tree from single category list.
     *
     * @param array $dataSet  A set of nodes.
     * @param int   $maxLevel Maximum levels deep of the tree to build.
     *
     * @return array
     */
    private function buildTree($dataSet, $maxLevel = 0)
    {
        $tree = new \ArrayIterator();
        $references = new \ArrayIterator();

        /** @var DocumentIterator $dataSet */
        foreach ($dataSet as $node) {
            if ($node->isActive()) {
                $this->buildNode($node, $references, $tree, $maxLevel);
            }
        }

        $this->expandNodes($references);

        $this->sortChildTree($tree);

        return $tree;
    }

    /**
     * Sorts category tree by sort field.
     *
     * @param array|\ArrayIterator $tree
     */
    protected function sortChildTree(&$tree)
    {
        /** @var AbstractCategoryDocument $node */
        if (is_array($tree)) {
            uasort($tree, [$this, 'sortNodes']);
            foreach ($tree as $node) {
                $children = $node->getChildren();
                if ($children) {
                    $this->sortChildTree($children);
                    $node->setChildren($children);
                }
            }
        } else {
            $tree->uasort([$this, 'sortNodes']);
            $tree->rewind();
            foreach ($tree as $node) {
                $children = $node->getChildren();
                if ($children) {
                    $this->sortChildTree($children);
                    $node->setChildren($children);
                }
            }
        }
    }

    /**
     * Sorts nodes by field sort if value equal then by field left.
     *
     * @param AbstractCategoryDocument $a
     * @param AbstractCategoryDocument $b
     *
     * @return int
     */
    public function sortNodes($a, $b)
    {
        if ($a->getSort() < $b->getSort()) {
            return -1;
        } elseif ($a->getSort() > $b->getSort()) {
            return 1;
        } elseif ($a->getLeft() < $b->getLeft()) {
            return -1;
        } elseif ($a->getLeft() > $b->getLeft()) {
            return 1;
        }

        return 0;
    }

    /**
     * Returns nested category tree.
     *
     * @param int  $maxLevel
     * @param bool $getHidden
     *
     * @return \ArrayIterator
     */
    public function getTree($maxLevel = 0, $getHidden = false)
    {
        $hash = $maxLevel . $getHidden;
        if (!isset($this->treeCache[$hash])) {
            $this->setLoadHiddenCategories($getHidden);
            $query = $this->buildQuery();
            $results = $this->repository->execute($query, Repository::RESULTS_OBJECT);
            $tree = $this->buildTree($results, $maxLevel);
            $this->treeCache[$hash] = $tree;
        }

        return $this->treeCache[$hash];
    }

    /**
     * @param int    $maxLevel
     * @param string $categoryId
     *
     * @return array
     * @throws \ErrorException
     */
    public function getPartialTree($maxLevel = 0, $categoryId = null)
    {
        if ($categoryId === null) {
            throw new \ErrorException('Category Id must be defined on getPartialTree() method');
        }
        $tree = $this->getTree($maxLevel, true);
        $tree->rewind();
        $partialTree = $this->findPartialTree($tree, $categoryId);

        return $partialTree;
    }

    /**
     * Returns partial tree by category ID.
     *
     * @param array|\ArrayIterator $tree
     * @param string               $categoryId
     *
     * @return array
     */
    protected function findPartialTree($tree, $categoryId)
    {
        /** @var AbstractCategoryDocument $node */
        foreach ($tree as $node) {
            if ($node->getId() == $categoryId) {
                return [$node];
            }
            if ($node->getChildren()) {
                $result = $this->findPartialTree($node->getChildren(), $categoryId);
                if (!empty($result)) {
                    return $result;
                }
            }
        }

        return [];
    }

    /**
     * @param Repository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * Gets current category ID.
     *
     * @return mixed
     */
    public function getCurrentCategoryId()
    {
        return $this->currentCategoryId;
    }

    /**
     * Temporary function for forcing categoryId parameter.
     *
     * @param string $categoryId
     */
    public function setCurrentCategoryId($categoryId)
    {
        $this->currentCategoryId = $categoryId;
    }

    /**
     * Gets current category document.
     *
     * @return mixed
     */
    public function getCurrentCategoryDocument()
    {
        return $this->currentLeaf;
    }

    /**
     * Set if load all categories or hidden.
     *
     * @param bool $param
     */
    protected function setLoadHiddenCategories($param)
    {
        $this->loadHiddenCategories = $param;
    }
}
