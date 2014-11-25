<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Twig;

use ONGR\ContentBundle\Service\CategoryService;

/**
 * CategoryExtension class.
 */
class CategoryExtension extends \Twig_Extension
{
    const NAME = 'category_extension';

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * Max category level to render to.
     *
     * @var int
     */
    private $maxLevel = null;

    /**
     * Category template for render.
     *
     * @var string
     */
    private $template = null;

    /**
     * @param CategoryService $service
     */
    public function __construct($service)
    {
        $this->categoryService = $service;
    }

    /**
     * Get name of the twig extension.
     *
     * @return string
     */
    public function getName()
    {
        $name = self::NAME;

        return $name;
    }

    /**
     * Sets template name for the renderer.
     *
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Gets template for the renderer.
     *
     * @return null|string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Sets max level.
     *
     * @param int $maxLevel
     */
    public function setMaxLevel($maxLevel)
    {
        $this->maxLevel = $maxLevel;
    }

    /**
     * Gets max level.
     *
     * @return null|int
     */
    public function getMaxLevel()
    {
        return $this->maxLevel;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            'category_tree' => new \Twig_SimpleFunction(
                'getCategoryTree',
                [
                    $this,
                    'getCategoryTree',
                ],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html'],
                ]
            ),
            'render_tree' => new \Twig_SimpleFunction(
                'renderCategoryTree',
                [
                    $this,
                    'renderCategoryTree',
                ],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html'],
                ]
            ),
            'category_child_tree' => new \Twig_SimpleFunction(
                'getCategoryChildTree',
                [
                    $this,
                    'getCategoryChildTree',
                ],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }

    /**
     * Renders category tree.
     *
     * @param \Twig_Environment $environment
     * @param array             $tree
     * @param string|null       $selectedCategory
     * @param string|null       $currentCategory
     * @param string|null       $template
     *
     * @return null|string
     */
    public function renderCategoryTree(
        \Twig_Environment $environment,
        $tree,
        $selectedCategory = null,
        $currentCategory = null,
        $template = null
    ) {
        if (count($tree)) {
            if ($template === null) {
                $template = $this->getTemplate();
            }

            return $environment->render(
                $template,
                [
                    'categories' => $tree,
                    'selected_category' => $selectedCategory,
                    'current_category' => $currentCategory,
                ]
            );
        }

        return null;
    }

    /**
     * Returns rendered category tree.
     *
     * @param \Twig_Environment $environment
     * @param string            $template
     * @param int               $maxLevel
     * @param null|string       $selectedCategory
     *
     * @return null|string
     */
    public function getCategoryTree(
        \Twig_Environment $environment,
        $template = 'ONGRContentBundle:Category:inc/categorytree.html.twig',
        $maxLevel = 0,
        $selectedCategory = null
    ) {
        $this->setMaxLevel($maxLevel);
        $this->setTemplate($template);

        $this->categoryService->setCurrentCategoryId($selectedCategory);
        $tree = $this->categoryService->getTree($this->getMaxLevel(), true);
        $currentCategory = $this->categoryService->getCurrentCategoryDocument();

        return $this->renderCategoryTree($environment, $tree, $selectedCategory, $currentCategory);
    }

    /**
     * Returns rendered category tree.
     *
     * @param \Twig_Environment $environment
     * @param string            $template
     * @param int               $maxLevel
     * @param null|string       $selectedCategory
     * @param null              $fromCategory
     *
     * @return null|string
     */
    public function getCategoryChildTree(
        \Twig_Environment $environment,
        $template = 'ONGRCategoryBundle:Category:inc/categorytree.html.twig',
        $maxLevel = 0,
        $selectedCategory = null,
        $fromCategory = null
    ) {
        $this->categoryService->setCurrentCategoryId($selectedCategory);

        $tree = $this->categoryService->getPartialTree($maxLevel, $fromCategory);
        $currentCategory = $this->categoryService->getCurrentCategoryDocument();

        return $this->renderCategoryTree($environment, $tree, $selectedCategory, $currentCategory, $template);
    }
}
