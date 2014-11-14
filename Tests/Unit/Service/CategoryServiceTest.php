<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Unit\Service;

use ONGR\ContentBundle\Service\CategoryService;
use ONGR\ElasticsearchBundle\Test\ElasticsearchTestCase;
use ONGR\TestingBundle\Document\ContentCategory;

/**
 * Provides tests for category service.
 */
class CategoryServiceTest extends ElasticsearchTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getDataArray()
    {
        return [
            'default' => [
                'content_category' => [
                    [
                        '_id' => 'cat1',
                        'active' => true,
                        'sort' => 1,
                        'left' => 2,
                        'parent_id' => 'oxrootid',
                        'level' => 1,
                        'hidden' => false,
                    ],
                    [
                        '_id' => 'cat2',
                        'active' => true,
                        'sort' => 2,
                        'left' => 8,
                        'parent_id' => 'oxrootid',
                        'level' => 1,
                        'hidden' => false,
                    ],
                    [
                        '_id' => 'cat3',
                        'active' => true,
                        'sort' => 1,
                        'left' => 1,
                        'parent_id' => 'oxrootid',
                        'level' => 1,
                        'current' => true,
                        'expanded' => true,
                        'hidden' => false,
                    ],
                    [
                        '_id' => 'cat4',
                        'active' => true,
                        'sort' => 1,
                        'left' => 3,
                        'parent_id' => 'oxrootid',
                        'level' => 1,
                        'hidden' => false,
                    ],
                    [
                        '_id' => 'cat41',
                        'active' => true,
                        'sort' => 1,
                        'left' => 4,
                        'parent_id' => 'cat4',
                        'level' => 2,
                        'hidden' => false,
                    ],
                    [
                        '_id' => 'cat42',
                        'active' => true,
                        'sort' => 1,
                        'left' => 5,
                        'parent_id' => 'cat4',
                        'level' => 2,
                        'hidden' => false,
                    ],
                    [
                        '_id' => 'cat421',
                        'active' => true,
                        'sort' => 2,
                        'left' => 7,
                        'parent_id' => 'cat42',
                        'level' => 3,
                        'hidden' => false,
                    ],
                    [
                        '_id' => 'cat422',
                        'active' => true,
                        'sort' => 1,
                        'left' => 6,
                        'parent_id' => 'cat42',
                        'level' => 3,
                        'hidden' => false,
                    ],
                    [
                        '_id' => 'cat5',
                        'active' => true,
                        'sort' => 1,
                        'left' => 3,
                        'parent_id' => 'oxrootid',
                        'level' => 1,
                        'hidden' => false,
                    ],
                    [
                        '_id' => 'cat6',
                        'active' => true,
                        'sort' => 1,
                        'left' => 9,
                        'parent_id' => 'oxrootid',
                        'level' => 1,
                        'hidden' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Mock helper.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getTestDataService()
    {
        $repository = $this->getMockBuilder('ElasticsearchBundle\\ORM\\Repository')
            ->disableOriginalConstructor()
            ->getMock();

        $manager = $this->getMockBuilder('ElasticsearchBundle\\ORM\\Manager')
            ->disableOriginalConstructor()
            ->getMock();
        $manager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repository));

        return $manager;
    }

    /**
     * Setter and getter tests.
     */
    public function testSetGetCurrentCategoryId()
    {
        $repository = $this->getManager()->getRepository('AcmeTestBundle:Category');

        $service = new CategoryService($repository);
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
     * @return ContentCategory
     */
    protected function buildCategory($category)
    {
        $cat = new ContentCategory();
        $cat->id = $category['id'];
        $cat->active = $category['active'];
        $cat->sort = $category['sort'];
        $cat->left = $category['left'];
        $cat->parentId = $category['parent_id'];
        $cat->setLevel($category['level']);
        if (isset($category['hidden'])) {
            $cat->hidden = $category['hidden'];
        }
        isset($category['current']) && $cat->setCurrent($category['current']);
        isset($category['expanded']) && $cat->setExpanded($category['expanded']);

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
                'parent_id' => 'oxrootid',
                'level' => 1,
                'hidden' => false,
            ],
            [
                'id' => 'cat2',
                'active' => true,
                'sort' => 2,
                'left' => 8,
                'parent_id' => 'oxrootid',
                'level' => 1,
                'hidden' => false,
            ],
            [
                'id' => 'cat3',
                'active' => true,
                'sort' => 1,
                'left' => 1,
                'parent_id' => 'oxrootid',
                'level' => 1,
                'current' => true,
                'expanded' => true,
                'hidden' => false,
            ],
            [
                'id' => 'cat4',
                'active' => true,
                'sort' => 1,
                'left' => 3,
                'parent_id' => 'oxrootid',
                'level' => 1,
                'hidden' => false,
            ],
            [
                'id' => 'cat41',
                'active' => true,
                'sort' => 1,
                'left' => 4,
                'parent_id' => 'cat4',
                'level' => 2,
                'hidden' => false,
            ],
            [
                'id' => 'cat42',
                'active' => true,
                'sort' => 1,
                'left' => 5,
                'parent_id' => 'cat4',
                'level' => 2,
                'hidden' => false,
            ],
            [
                'id' => 'cat421',
                'active' => true,
                'sort' => 2,
                'left' => 7,
                'parent_id' => 'cat42',
                'level' => 3,
                'hidden' => false,
            ],
            [
                'id' => 'cat422',
                'active' => true,
                'sort' => 1,
                'left' => 6,
                'parent_id' => 'cat42',
                'level' => 3,
                'hidden' => false,
            ],
            [
                'id' => 'cat5',
                'active' => true,
                'sort' => 1,
                'left' => 3,
                'parent_id' => 'oxrootid',
                'level' => 1,
                'hidden' => false,
            ],
            [
                'id' => 'cat6',
                'active' => true,
                'sort' => 1,
                'left' => 9,
                'parent_id' => 'oxrootid',
                'level' => 1,
                'hidden' => false,
            ],
        ];

        /** @var Category[] $data */
        $data = [];
        foreach ($catData as $category) {
            $data[$category['id']] = $this->buildCategory($category);
        }
        foreach ($catData as $category) {
            if ($category['parent_id'] == 'oxrootid') {
                continue;
            }
            $data[$category['id']]->setParent($data[$category['parent_id']]);
            $data[$category['parent_id']]->setChild($category['id'], $data[$category['id']]);
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

        $service = new CategoryService($repository);

        $service->setCurrentCategoryId('cat3');
        $service->getCurrentCategoryDocument();
        $service->setLimit(count($data) - 1);

        /** @var \ArrayIterator $result */
        $result = $service->getTree();

        $expectedResult = [
            'cat3' => clone $data['cat3'],
            'cat1' => clone $data['cat1'],
            'cat4' => clone $data['cat4'],
            'cat5' => clone $data['cat5'],
            // Skipped by limit 'cat6' => clone $data['cat6'], .
            'cat2' => clone $data['cat2'],
        ];

        $this->assertEquals($expectedResult, $result->getArrayCopy());
    }

    /**
     * Tests if proper current leaf is returned.
     *
     * @param Category[] $data
     *
     * @dataProvider treeDataProvider()
     */
    public function testGetCurrentCategoryDocument(array $data)
    {
        $service = new CategoryService($this->getManager()->getRepository('AcmeTestBundle:Category'));
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
                'parent_id' => 'oxrootid',
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
                'parent_id' => 'oxrootid',
                'level' => 1,
            ]
        );

        $cat3 = $this->buildCategory(
            [
                'id' => 'cat3',
                'active' => true,
                'sort' => 1,
                'left' => 1,
                'parent_id' => 'oxrootid',
                'level' => 1,
                'current' => true,
                'expanded' => true,
            ]
        );

        $cat4 = $this->buildCategory(
            [
                'id' => 'cat4',
                'active' => true,
                'sort' => 1,
                'left' => 3,
                'parent_id' => 'oxrootid',
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

        $cat4->setChild('cat42', $cat42);
        $cat4->setChild('cat41', $cat41);
        $cat42->setChild('cat421', $cat421);

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
        /** @var $categoryService CategoryService|\PHPUnit_Framework_MockObject_MockObject */
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

    public function getCategoryDataProvider()
    {
        $rawData = [
            [
                'id' => 'cat1',
                'active' => true,
                'sort' => 1,
                'left' => 2,
                'parent_id' => 'oxrootid',
                'level' => 1,
                'hidden' => false,
            ],
            [
                'id' => 'cat2',
                'active' => true,
                'sort' => 2,
                'left' => 8,
                'parent_id' => 'oxrootid',
                'level' => 1,
                'hidden' => false,
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
     * @param string          $categoryId
     * @param ContentCategory $category
     *
     * @dataProvider getCategoryDataProvider()
     */
    public function testGetCategory($categoryId, $category)
    {
        $service = new CategoryService($this->getManager()->getRepository('ONGRTestingBundle:ContentCategory'));
        $result = $service->getCategory($categoryId);
        $this->assertEquals($category, $result);
    }
}
