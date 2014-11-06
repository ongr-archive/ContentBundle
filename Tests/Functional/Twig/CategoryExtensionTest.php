<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Functional\Twig;

use ONGR\ElasticsearchBundle\Test\ElasticsearchTestCase;

/**
 * Category extension functional test.
 */
class CategoryExtensionTest extends ElasticsearchTestCase
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
                        '_id' => '1',
                        'parent_id' => 'oxrootid',
                        'title' => 'root',
                        'active' => true,
                        'sort' => 1,
                    ],
                    [
                        '_id' => '2',
                        'parent_id' => '1',
                        'title' => 'Sub category 2nd level 1st item',
                        'active' => true,
                        'sort' => 4,
                    ],
                    [
                        '_id' => '3',
                        'parent_id' => '2',
                        'title' => 'Sub category 3rd level 1st item',
                        'active' => true,
                        'sort' => 7,
                    ],
                    [
                        '_id' => '4',
                        'parent_id' => '1',
                        'title' => 'Sub category 2nd level 2nd item',
                        'active' => true,
                        'sort' => 5,
                    ],
                    [
                        '_id' => '5',
                        'parent_id' => 'oxrootid',
                        'title' => 'Rood 2nd item',
                        'active' => true,
                        'sort' => 2,
                    ],
                    [
                        '_id' => '6',
                        'parent_id' => '2',
                        'title' => 'Sub category 3rd level 2nd item',
                        'active' => true,
                        'sort' => 8,
                    ],
                ],
            ],
        ];
    }

    /**
     * Data provider for testCategoryTree().
     *
     * @return array
     */
    public function testCategoryTreeData()
    {
        $out = [];
        // Case #0 no selected category, no max level.

        $root = [
            'type' => 'ul',
            'children' => [
                [
                    'type' => 'li',
                    'value' => 'root',
                    'attributes' => ['class' => 'level-1 has-children'],
                ],
                [
                    'type' => 'li',
                    'value' => 'Rood 2nd item',
                    'attributes' => ['class' => 'level-1'],
                ],
            ],
        ];
        $out[] = [$root];

        // Case #2 3rd level category selected, but max level is only 2. should not generate a full tree.
        $expected = $root;
        $secondLevelChildren = [
            [
                'type' => 'ul',
                'children' => [
                    [
                        'type' => 'li',
                        'value' => 'Sub category 2nd level 1st item',
                        'attributes' => ['class' => 'level-2'],
                    ],
                    [
                        'type' => 'li',
                        'value' => 'Sub category 2nd level 2nd item',
                        'attributes' => ['class' => 'level-2'],
                    ],
                ],
            ],
        ];
        $expected['children'][0]['children'] = $secondLevelChildren;
        $out[] = [$expected, 3, 2];

        // Case #1 3rd level category selected, should generate full tree.
        $expected = $root;
        $thirdLevelChildren = [
            [
                'type' => 'ul',
                'children' => [
                    [
                        'type' => 'li',
                        'value' => 'Sub category 3rd level 1st item',
                        'attributes' => ['class' => 'level-3 current'],
                    ],
                    [
                        'type' => 'li',
                        'value' => 'Sub category 3rd level 2nd item',
                        'attributes' => ['class' => 'level-3'],
                    ],
                ],
            ],
        ];

        $secondLevelChildren[0]['children'][0]['attributes']['class'] = 'level-2 has-children';
        $secondLevelChildren[0]['children'][0]['children'] = $thirdLevelChildren;

        $expected['children'][0]['children'] = $secondLevelChildren;
        $out[] = [$expected, 3, 0];

        return $out;
    }

    /**
     * Check if category tree is built as expected with the default template.
     *
     * @param array     $expectedOutput
     * @param int       $selectedCategory
     * @param int       $maxLevel
     *
     * @dataProvider testCategoryTreeData()
     */
    public function testCategoryTree($expectedOutput, $selectedCategory = 0, $maxLevel = 0)
    {
        $container = self::createClient()->getContainer();

        /** @var \Twig_Environment $environment */
        $environment = clone $container->get('twig');
        $environment->setLoader(new \Twig_Loader_String());
        $treeTemplate = file_get_contents(__DIR__ . '/../../../Resources/views/Category/tree.html.twig');

        $result = $environment->render("{{ getCategoryTree('{$treeTemplate}', {$maxLevel}, {$selectedCategory}) }}");
        $tree = $this->getTreeData(simplexml_load_string($result));

        $this->assertEquals($expectedOutput, $tree);
    }

    /**
     * Check if category child tree is built as expected with the default template.
     */
    public function testCategoryChildTree()
    {
        $container = self::createClient()->getContainer();

        /** @var \Twig_Environment $environment */
        $environment = clone $container->get('twig');
        $environment->setLoader(new \Twig_Loader_String());
        $treeTemplate = file_get_contents(__DIR__ . '/../../../Resources/views/Category/tree.html.twig');

        $expectedTree = [
            'type' => 'ul',
            'children' => [
                [
                    'type' => 'li',
                    'value' => 'Sub category 2nd level 1st item',
                    'attributes' => ['class' => 'level-2 has-children'],
                    'children' => [
                        [
                            'type' => 'ul',
                            'children' => [
                                [
                                    'type' => 'li',
                                    'value' => 'Sub category 3rd level 1st item',
                                    'attributes' => ['class' => 'level-3 current'],
                                ],
                                [
                                    'type' => 'li',
                                    'value' => 'Sub category 3rd level 2nd item',
                                    'attributes' => ['class' => 'level-3'],
                                ],
                            ],
                        ],
                    ]
                ],
            ]
        ];

        $result = $environment->render("{{ getCategoryChildTree('{$treeTemplate}', 0, 3, 2) }}");
        $tree = $this->getTreeData(simplexml_load_string($result));

        $this->assertEquals($expectedTree, $tree);
    }

    /**
     * Returns tree data.
     *
     * @param \SimpleXMLElement $element
     *
     * @return array
     */
    private function getTreeData($element)
    {
        $tree = [];
        $tree['type'] = $element->getName();

        if (strlen(trim($element)) > 0) {
            $tree['value'] = trim($element);
        }

        if (count((array)$element->attributes())) {
            foreach ($element->attributes() as $key => $value) {
                $tree['attributes'][$key] = (string)$value;
            }
        }

        if ($element->children()) {
            foreach ($element as $child) {
                $tree['children'][] = $this->getTreeData($child);
            }
        }

        return $tree;
    }
}
