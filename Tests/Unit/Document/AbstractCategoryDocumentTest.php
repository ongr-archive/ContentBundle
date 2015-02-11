<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Unit\Document;

use ONGR\ContentBundle\Document\AbstractCategoryDocument;

/**
 * Provides tests for category document.
 */
class AbstractCategoryDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testCategoryDocument().
     *
     * @return array
     */
    public function categoryDocumentDataProvider()
    {
        $catData = [
            [
                [
                    'active' => false,
                    'sort' => 1,
                    'left' => 2,
                    'right' => 5,
                    'level' => 2,
                    'parent_id' => 'testrootid',
                    'hidden' => false,
                    'title' => 'cat1',
                    'expanded' => false,
                    'current' => false,
                    'breadcrumbs' => ['bc1' => 'bcrumb', 'bc3' => 'bcrumb3'],
                    'children' => '1',
                ],
            ],
            [
                [
                    'active' => true,
                    'sort' => 2,
                    'left' => 2,
                    'right' => 5,
                    'level' => 3,
                    'parent_id' => 'testrootid',
                    'hidden' => true,
                    'title' => 'cat2',
                    'expanded' => true,
                    'current' => true,
                    'breadcrumbs' => ['bc2' => 'bcrumb2', 'bc4' => 'bcrumb4'],
                    'children' => '1',
                ],
            ],
        ];

        return $catData;
    }

    /**
     * Tests Category document.
     *
     * @param array $data
     *
     * @dataProvider categoryDocumentDataProvider()
     */
    public function testCategoryDocument(array $data)
    {
        /** @var AbstractCategoryDocument $cat */
        $cat = $this->getMockForAbstractClass('ONGR\ContentBundle\Document\AbstractCategoryDocument');
        $cat->setActive($data['active']);
        $this->assertEquals($data['active'], $cat->isActive());
        $this->assertEquals($data['active'], $cat->getActive());

        foreach ($data['breadcrumbs'] as $key => $value) {
            $cat->setBreadcrumb($value, $key);
        }
        $cat->setLevel(1);
        $this->assertEquals(1, $cat->getLevel());

        $this->assertEquals($data['breadcrumbs'], $cat->getBreadcrumbs());

        $cat->setBreadcrumbs($data['breadcrumbs']);
        $this->assertEquals($data['breadcrumbs'], $cat->getBreadcrumbs());

        $cat->addBreadcrumb('bcrumb6');
        $this->assertEquals('bcrumb6', $cat->getBreadcrumb(0));

        $this->assertEquals(true, $cat->hasBreadcrumbs());

        $cat->setTitle($data['title']);
        $this->assertEquals($data['title'], $cat->getTitle());

        $cat->setParentId($data['parent_id']);
        $this->assertEquals($data['parent_id'], $cat->getParentId());

        $cat->setCurrent($data['current']);
        $this->assertEquals($data['current'], $cat->getCurrent());
        $this->assertEquals($data['current'], $cat->isCurrent());

        $cat->setExpanded($data['expanded']);
        $this->assertEquals($data['expanded'], $cat->getExpanded());

        $cat->setSort($data['sort']);
        $this->assertEquals($data['sort'], $cat->getSort());

        $cat->setLeft($data['left']);
        $this->assertEquals($data['left'], $cat->getLeft());

        $cat->setRight($data['right']);
        $this->assertEquals($data['right'], $cat->getRight());

        $this->assertEquals(false, $cat->hasChildren());
        $this->assertEquals(false, $cat->hasVisibleChildren());

        /** @var AbstractCategoryDocument $cat2 */
        $cat2 = $this->getMockForAbstractClass('ONGR\ContentBundle\Document\AbstractCategoryDocument');
        $cat2->setHidden(false);
        $cat->addChild($cat2);
        $this->assertEquals(true, $cat->hasVisibleChildren());
        $this->assertEquals($cat2, $cat->getChild('0'));
        $this->assertEquals(false, $cat2->isHidden());
        $this->assertEquals(false, $cat2->getHidden());

        /** @var AbstractCategoryDocument $cat3 */
        $cat3 = $this->getMockForAbstractClass('ONGR\ContentBundle\Document\AbstractCategoryDocument');
        $cat3->setHidden(true);
        $cat3->setChild($cat3, '1');
        $this->assertEquals(false, $cat2->hasVisibleChildren());
    }
}
