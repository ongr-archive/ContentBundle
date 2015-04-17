<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Functional\Service;

use ONGR\ContentBundle\Service\CategoryService;
use ONGR\ContentBundle\Tests\app\fixture\Acme\TestBundle\Document\Category;
use ONGR\ElasticsearchBundle\Test\AbstractElasticsearchTestCase;

/**
 * Provides tests for category service.
 */
class CategoryServiceTest extends AbstractElasticsearchTestCase
{
    /**
     * @var string
     */
    private $rootId = 'root_id';

    /**
     * {@inheritdoc}
     */
    protected function getDataArray()
    {
        return [
            'default' => [
                'category' => [
                    [
                        '_id' => 'cat1',
                        'active' => true,
                        'sort' => 1,
                        'left' => 2,
                        'parent_id' => $this->rootId,
                        'level' => 1,
                        'is_hidden' => false,
                    ],
                    [
                        '_id' => 'cat2',
                        'active' => true,
                        'sort' => 2,
                        'left' => 8,
                        'parent_id' => $this->rootId,
                        'level' => 1,
                        'is_hidden' => false,
                    ],
                    [
                        '_id' => 'cat3',
                        'active' => true,
                        'sort' => 1,
                        'left' => 1,
                        'parent_id' => $this->rootId,
                        'level' => 1,
                        'is_hidden' => false,
                    ],
                    [
                        '_id' => 'cat4',
                        'active' => true,
                        'sort' => 1,
                        'left' => 3,
                        'parent_id' => $this->rootId,
                        'level' => 1,
                        'is_hidden' => false,
                    ],
                    [
                        '_id' => 'cat41',
                        'active' => true,
                        'sort' => 1,
                        'left' => 4,
                        'parent_id' => 'cat4',
                        'level' => 2,
                        'is_hidden' => false,
                    ],
                    [
                        '_id' => 'cat42',
                        'active' => true,
                        'sort' => 1,
                        'left' => 5,
                        'parent_id' => 'cat4',
                        'level' => 2,
                        'is_hidden' => false,
                    ],
                    [
                        '_id' => 'cat421',
                        'active' => true,
                        'sort' => 2,
                        'left' => 7,
                        'parent_id' => 'cat42',
                        'level' => 3,
                        'is_hidden' => false,
                    ],
                    [
                        '_id' => 'cat422',
                        'active' => true,
                        'sort' => 1,
                        'left' => 6,
                        'parent_id' => 'cat42',
                        'level' => 3,
                        'is_hidden' => false,
                    ],
                    [
                        '_id' => 'cat5',
                        'active' => true,
                        'sort' => 1,
                        'left' => 3,
                        'parent_id' => $this->rootId,
                        'level' => 1,
                        'is_hidden' => false,
                    ],
                    [
                        '_id' => 'cat6',
                        'active' => true,
                        'sort' => 1,
                        'left' => 9,
                        'parent_id' => $this->rootId,
                        'level' => 1,
                        'is_hidden' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Setter and getter tests.
     */
    public function testSetGetCurrentCategoryId()
    {
        $repository = $this->getManager()->getRepository('AcmeTestBundle:Category');

        $service = new CategoryService($repository, $this->rootId);
        $service->setRepository($repository);

        $id = 'testid';

        $service->setCurrentCategoryId($id);
        $this->assertEquals($id, $service->getCurrentCategoryId());
    }

    /**
     * Builds a category.
     *
     * @param array $category
     *
     * @return Category
     */
    protected function buildCategory($category)
    {
        $cat = $this->getManager()->getRepository('AcmeTestBundle:Category')->createDocument();
        $cat->setId($category['id']);
        $cat->setActive($category['active']);
        $cat->setSort($category['sort']);
        $cat->setLeft($category['left']);
        $cat->setParentId($category['parent_id']);
        $cat->setLevel($category['level']);
        isset($category['is_hidden']) && $cat->setHidden($category['is_hidden']);
        isset($category['is_current']) && $cat->setCurrent($category['is_current']);
        isset($category['is_expanded']) && $cat->setExpanded($category['is_expanded']);
        $cat->__setInitialized(true);

        return $cat;
    }

    /**
     * Provides tree dummy data for multiple tests.
     *
     * @return array
     */
    public function treeDataProvider()
    {
        $catData = [
            [
                'id' => 'cat1',
                'active' => true,
                'sort' => 1,
                'left' => 2,
                'parent_id' => $this->rootId,
                'level' => 1,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat2',
                'active' => true,
                'sort' => 2,
                'left' => 8,
                'parent_id' => $this->rootId,
                'level' => 1,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat3',
                'active' => true,
                'sort' => 1,
                'left' => 1,
                'parent_id' => $this->rootId,
                'level' => 1,
                'is_expanded' => true,
                'is_current' => true,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat4',
                'active' => true,
                'sort' => 1,
                'left' => 3,
                'parent_id' => $this->rootId,
                'level' => 1,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat41',
                'active' => true,
                'sort' => 1,
                'left' => 4,
                'parent_id' => 'cat4',
                'level' => 2,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat42',
                'active' => true,
                'sort' => 1,
                'left' => 5,
                'parent_id' => 'cat4',
                'level' => 2,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat421',
                'active' => true,
                'sort' => 2,
                'left' => 7,
                'parent_id' => 'cat42',
                'level' => 3,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat422',
                'active' => true,
                'sort' => 1,
                'left' => 6,
                'parent_id' => 'cat42',
                'level' => 3,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat5',
                'active' => true,
                'sort' => 1,
                'left' => 3,
                'parent_id' => $this->rootId,
                'level' => 1,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat6',
                'active' => true,
                'sort' => 1,
                'left' => 9,
                'parent_id' => $this->rootId,
                'level' => 1,
                'is_hidden' => false,
            ],
        ];

        /** @var Category[] $data */
        $data = [];
        foreach ($catData as $category) {
            $data[$category['id']] = $this->buildCategory($category);
        }
        foreach ($catData as $category) {
            if ($category['parent_id'] == $this->rootId) {
                continue;
            }
            $data[$category['id']]->setParent($data[$category['parent_id']]);
            $data[$category['parent_id']]->setChild($data[$category['id']], $category['id']);
        }

        return [['data' => $data]];
    }

    /**
     * Tests get Tree.
     *
     * @param array $data
     *
     * @dataProvider treeDataProvider()
     */
    public function testGetTree(array $data)
    {
        $repository = $this->getManager()->getRepository('AcmeTestBundle:Category');

        $service = new CategoryService($repository, $this->rootId);

        $service->setCurrentCategoryId('cat3');
        $service->getCurrentCategoryDocument();
        $service->setLimit(count($data) - 1);

        /** @var \ArrayIterator $result */
        $result = $service->getTree();

        $expectedResult = [
            'cat3' => clone $data['cat3'],
            'cat1' => clone $data['cat1'],
            'cat5' => clone $data['cat5'],
            'cat4' => clone $data['cat4'],
            // Skipped by limit 'cat6' => clone $data['cat6'], .
            'cat2' => clone $data['cat2'],
        ];

        $gotResult = [];
        foreach ($result as $key => $value) {
            $gotResult[$key] = clone $value;
        }

        $this->assertEquals($expectedResult, $gotResult);
    }

    /**
     * Tests if proper current leaf is returned.
     *
     * @param array|Category[] $data
     *
     * @dataProvider treeDataProvider()
     */
    public function testGetCurrentCategoryDocument(array $data)
    {
        $service = new CategoryService($this->getManager()->getRepository('AcmeTestBundle:Category'), $this->rootId);
        $service->setCurrentCategoryId('cat42');

        $leaf = $service->getCurrentCategoryDocument();
        $this->assertEquals(null, $leaf);

        /** @var \ArrayIterator $result */
        $service->getTree();

        $expected = $data['cat42'];
        $expected->setCurrent(true);
        $expected->setExpanded(true);

        $expected->getParent()->setExpanded(true);

        $leaf = $service->getCurrentCategoryDocument();
        $this->assertEquals($expected, $leaf);
    }

    /**
     * Data provider for testGetPartialTree().
     *
     * @return array
     */
    public function getPartialTreeDataProvider()
    {
        // Case #0.
        $cat1 = $this->buildCategory(
            [
                'id' => 'cat1',
                'active' => true,
                'sort' => 1,
                'left' => 2,
                'parent_id' => $this->rootId,
                'level' => 1,
            ]
        );

        $out[] = [
            new \ArrayIterator([$cat1]),
            5,
            'cat1',
            [$cat1],
        ];

        // Case #1 test when first item shouldn't be found.
        $out[] = [
            new \ArrayIterator([$cat1]),
            5,
            'cat2',
            [],
        ];

        // Case #2 test finding in deeper level with multiple side categories.
        $cat2 = $this->buildCategory(
            [
                'id' => 'cat2',
                'active' => true,
                'sort' => 2,
                'left' => 8,
                'parent_id' => $this->rootId,
                'level' => 1,
            ]
        );

        $cat3 = $this->buildCategory(
            [
                'id' => 'cat3',
                'active' => true,
                'sort' => 1,
                'left' => 1,
                'parent_id' => $this->rootId,
                'level' => 1,
            ]
        );

        $cat4 = $this->buildCategory(
            [
                'id' => 'cat4',
                'active' => true,
                'sort' => 1,
                'left' => 3,
                'parent_id' => $this->rootId,
                'level' => 1,
            ]
        );

        $cat41 = $this->buildCategory(
            [
                'id' => 'cat41',
                'active' => true,
                'sort' => 1,
                'left' => 4,
                'parent_id' => 'cat4',
                'level' => 2,
            ]
        );

        $cat42 = $this->buildCategory(
            [
                'id' => 'cat42',
                'active' => true,
                'sort' => 1,
                'left' => 5,
                'parent_id' => 'cat4',
                'level' => 2,
            ]
        );

        $cat421 = $this->buildCategory(
            [
                'id' => 'cat421',
                'active' => true,
                'sort' => 2,
                'left' => 7,
                'parent_id' => 'cat42',
                'level' => 3,
            ]
        );

        $tree = [
            $cat1,
            $cat2,
            $cat3,
            $cat4,
        ];

        $cat4->setChild($cat42, 'cat42');
        $cat4->setChild($cat41, 'cat41');
        $cat42->setChild($cat421, 'cat421');

        $out[] = [
            new \ArrayIterator($tree),
            5,
            'cat42',
            [$cat42],
        ];

        // Case #3 test finding in deeper level when it shouldn't be actually found.
        $out[] = [
            new \ArrayIterator($tree),
            5,
            'cat45',
            [],
        ];

        // Case #4 test with improper arguments.
        $out[] = [
            [],
            0,
            null,
            null,
            'Category Id must be defined on getPartialTree() method',
        ];

        return $out;
    }

    /**
     * Tests getPartialTree.
     *
     * @param \ArrayIterator $tree
     * @param int            $maxLevel
     * @param int            $categoryId
     * @param \ArrayIterator $expectedTree
     * @param string         $exception
     *
     * @dataProvider getPartialTreeDataProvider
     */
    public function testGetPartialTree($tree, $maxLevel, $categoryId, $expectedTree, $exception = '')
    {
        /* @var CategoryService|\PHPUnit_Framework_MockObject_MockObject $categoryService */
        $categoryService = $this->getMockBuilder('ONGR\ContentBundle\Service\CategoryService')
            ->disableOriginalConstructor()
            ->setMethods(['getTree'])
            ->getMock();
        if (!empty($exception)) {
            $this->setExpectedException('\ErrorException', $exception);
        } else {
            $categoryService->expects($this->once())->method('getTree')->with($maxLevel, true)->willReturn($tree);
        }

        $actualTree = $categoryService->getPartialTree($maxLevel, $categoryId);
        $this->assertEquals($expectedTree, $actualTree);
    }

    /**
     * Prepares data for testGetCategory().
     *
     * @return array
     */
    public function getCategoryDataProvider()
    {
        $rawData = [
            [
                'id' => 'cat1',
                'active' => true,
                'sort' => 1,
                'left' => 2,
                'parent_id' => $this->rootId,
                'level' => 1,
                'is_hidden' => false,
            ],
            [
                'id' => 'cat2',
                'active' => true,
                'sort' => 2,
                'left' => 8,
                'parent_id' => $this->rootId,
                'level' => 1,
                'is_hidden' => false,
            ],
        ];

        $data = [];
        foreach ($rawData as $case) {
            $data[] = [
                'categoryId' => $case['id'],
                'category' => $this->buildCategory($case),
            ];
        }

        return $data;
    }

    /**
     * Tests get Tree.
     *
     * @param string   $categoryId
     * @param Category $category
     *
     * @dataProvider getCategoryDataProvider()
     */
    public function testGetCategory($categoryId, $category)
    {
        $service = new CategoryService($this->getManager()->getRepository('AcmeTestBundle:Category'), $this->rootId);
        $result = $service->getCategory($categoryId);
        $this->assertEquals($category, $result);
    }
}
