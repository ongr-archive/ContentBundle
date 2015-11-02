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

use ErrorException;
use ONGR\ContentBundle\Service\CategoryService;
use ONGR\ElasticsearchBundle\Service\Repository;

/**
 * This class holds unit tests for category service.
 */
class CategoryServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Repository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $repositoryMock;

    /**
     * @var string
     */
    private $rootId = 'rootId';

    /**
     * Before a test method is run, a template method called setUp() is invoked.
     */
    public function setUp()
    {
        $this->repositoryMock = $this->getMockBuilder('ONGR\ElasticsearchBundle\Service\Repository')
            ->setMethods(['execute'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Data provider for testSortNodes test.
     *
     * @return array
     */
    public function sortNodeDataProvider()
    {
        $out = [
            ['getSort', 1, 2, -1],
            ['getSort', 2, 1, 1],
            ['getSort', 1, 1, 0],
            ['getLeft', 1, 2, -1],
            ['getLeft', 2, 1, 1],
            ['getLeft', 1, 1, 0],
        ];

        return $out;
    }

    /**
     * Tests sortNode.
     *
     * @param string $method
     * @param int    $first
     * @param int    $second
     * @param int    $expected
     *
     * @dataProvider sortNodeDataProvider
     */
    public function testIfSortNodesMethodReturnsValuesAsExpected($method, $first, $second, $expected)
    {
        $categoryService = new CategoryService($this->repositoryMock, $this->rootId);

        $a = $this->getMockBuilder('ONGR\ContentBundle\Document\AbstractCategoryDocument')
            ->setMethods([$method])
            ->getMockForAbstractClass();
        $a->expects($this->any())->method($method)->willReturn($first);

        $b = $this->getMockBuilder('ONGR\ContentBundle\Document\AbstractCategoryDocument')
            ->setMethods([$method])
            ->getMockForAbstractClass();
        $b->expects($this->any())->method($method)->willReturn($second);

        $this->assertEquals($expected, $categoryService->sortNodes($a, $b));
    }

    /**
     * Tests if exception is thrown.
     *
     * @expectedException ErrorException
     */
    public function testGetPartialTreeErrorExceptionWhenCategoryIdIsNull()
    {
        $categoryService = new CategoryService($this->repositoryMock, $this->rootId);
        $categoryService->getPartialTree(0, null);
    }
}
