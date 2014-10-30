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
use ONGR\ContentBundle\Tests\app\fixture\Acme\TestBundle\Document\Category;
use ONGR\ElasticsearchBundle\Test\ElasticsearchTestCase;

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
                'category' => [
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
     * @return Category
     */
    protected function buildCategory($category)
    {
        $cat = new Category();
        $cat->id = $category['id'];
        $cat->active = $category['active'];
        $cat->sort = $category['sort'];
        $cat->left = $category['left'];
        $cat->parentId = $category['parent_id'];
        $cat->setLevel($category['level']);
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
            ],
            [
                'id' => 'cat2',
                'active' => true,
                'sort' => 2,
                'left' => 8,
                'parent_id' => 'oxrootid',
                'level' => 1,
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
            ],
            [
                'id' => 'cat4',
                'active' => true,
                'sort' => 1,
                'left' => 3,
                'parent_id' => 'oxrootid',
                'level' => 1,
            ],
            [
                'id' => 'cat41',
                'active' => true,
                'sort' => 1,
                'left' => 4,
                'parent_id' => 'cat4',
                'level' => 2,
            ],
            [
                'id' => 'cat42',
                'active' => true,
                'sort' => 1,
                'left' => 5,
                'parent_id' => 'cat4',
                'level' => 2,
            ],
            [
                'id' => 'cat421',
                'active' => true,
                'sort' => 2,
                'left' => 7,
                'parent_id' => 'cat42',
                'level' => 3,
            ],
            [
                'id' => 'cat422',
                'active' => true,
                'sort' => 1,
                'left' => 6,
                'parent_id' => 'cat42',
                'level' => 3,
            ],
            [
                'id' => 'cat5',
                'active' => true,
                'sort' => 1,
                'left' => 3,
                'parent_id' => 'oxrootid',
                'level' => 1,
            ],
            [
                'id' => 'cat6',
                'active' => true,
                'sort' => 1,
                'left' => 9,
                'parent_id' => 'oxrootid',
                'level' => 1,
            ],
        ];

        $data = [];
        foreach ($catData as $category) {
            $data[$category['id']] = $this->buildCategory($category);
        }

        return [['data' => $data]];
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

        $out[] = [new \ArrayIterator([$cat1]), 5, 'cat1', [$cat1]];

        // Case #1 test finding in deeper level with multiple side categories.
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

        $tree = [$cat1, $cat2, $cat3, $cat4];

        $cat4->setChild('cat42', $cat42);
        $cat4->setChild('cat41', $cat41);
        $cat42->setChild('cat421', $cat421);

        $out[] = [new \ArrayIterator($tree), 5, 'cat42', [$cat42]];

        // Case #2 test with improper arguments.
        $out[] = [[], 0, null, null, 'Category Id must be defined on getPartialTree() method'];

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
        /** @var CategoryService|\PHPUnit_Framework_MockObject_MockObject $categoryService */
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
}
