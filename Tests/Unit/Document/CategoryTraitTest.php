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

use ONGR\ContentBundle\Document\Traits\CategoryTrait;

/**
 * Provides tests for category trait.
 */
class CategoryTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides data for testCategoryTrait().
     *
     * @return array
     */
    public function categoryTraitDataProvider()
    {
        $catData = [
            [
                [
                    'active' => false,
                    'sort' => 1,
                    'left' => 2,
                    'right' => 5,
                    'level' => 2,
                    'parent_id' => 'oxrootid',
                    'hidden' => false,
                    'title' => 'cat1',
                    'expanded' => false,
                    'current' => false,
                    'breadcrumbs' => ['bc1' => 'bcrumb', 'bc3' => 'bcrumb3'],
                ],
            ],
            [
                [
                    'active' => true,
                    'sort' => 2,
                    'left' => 2,
                    'right' => 5,
                    'level' => 3,
                    'parent_id' => 'oxrootid',
                    'hidden' => true,
                    'title' => 'cat2',
                    'expanded' => true,
                    'current' => true,
                    'breadcrumbs' => ['bc2' => 'bcrumb2', 'bc4' => 'bcrumb4'],
                ],
            ],
        ];

        return $catData;
    }

    /**
     * Tests Category trait.
     *
     * @param array $data
     *
     * @dataProvider categoryTraitDataProvider()
     */
    public function testCategoryTrait(array $data)
    {
        /** @var CategoryTrait $cat */
        $cat = $this->getMockForTrait('ONGR\\ContentBundle\\Document\\Traits\\CategoryTrait');
        $cat->setIsActive($data['active']);
        $this->assertEquals($data['active'], $cat->isActive());
        $this->assertEquals($data['active'], $cat->getIsActive());

        foreach ($data['breadcrumbs'] as $key => $value) {
            $cat->setBreadcrumb($value, $key);
        }

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

        $cat->setIsCurrent($data['current']);
        $this->assertEquals($data['current'], $cat->getIsCurrent());
        $this->assertEquals($data['current'], $cat->isCurrent());

        $cat->setIsExpanded($data['expanded']);
        $this->assertEquals($data['expanded'], $cat->getIsExpanded());

        $cat->setSort($data['sort']);
        $this->assertEquals($data['sort'], $cat->getSort());

        $cat->setLeft($data['left']);
        $this->assertEquals($data['left'], $cat->getLeft());

        $cat->setRight($data['right']);
        $this->assertEquals($data['right'], $cat->getRight());

        $this->assertEquals(false, $cat->hasChildren());
        $this->assertEquals(false, $cat->hasVisibleChildren());

        /** @var CategoryTrait $cat2 */
        $cat2 = $this->getMockForTrait('ONGR\\ContentBundle\\Document\\Traits\\CategoryTrait');
        $cat2->setIsHidden(false);
        $cat->addChild($cat2);
        $this->assertEquals(true, $cat->hasVisibleChildren());
        $this->assertEquals($cat2, $cat->getChild('0'));
        $this->assertEquals(false, $cat2->isHidden());
        $this->assertEquals(false, $cat2->getIsHidden());

        /** @var CategoryTrait $cat3 */
        $cat3 = $this->getMockForTrait('ONGR\\ContentBundle\\Document\\Traits\\CategoryTrait');
        $cat3->setIsHidden(true);
        $cat2->addChild($cat3);
        $this->assertEquals(false, $cat2->hasVisibleChildren());
    }
}
