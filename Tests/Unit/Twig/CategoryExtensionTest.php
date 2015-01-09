<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Unit\Twig;

use ONGR\ContentBundle\Service\CategoryService;
use ONGR\ContentBundle\Twig\CategoryExtension;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Twig_Environment;

class CategoryExtensionTest extends WebTestCase
{
    /**
     * Test if name is set on extension.
     */
    public function testGetName()
    {
        $extension = new CategoryExtension(null);
        $this->assertEquals(CategoryExtension::NAME, $extension->getName());
    }

    /**
     * Test if max level is set correctly.
     */
    public function testSetGetMaxLevel()
    {
        $maxLevel = 10;

        $extension = new CategoryExtension(null);
        $extension->setMaxLevel($maxLevel);
        $this->assertEquals($maxLevel, $extension->getMaxLevel());
    }

    /**
     * Test if template is set correctly.
     */
    public function testSetGetTemplate()
    {
        $template = 'test template';

        $extension = new CategoryExtension(null);
        $extension->setTemplate($template);
        $this->assertEquals($template, $extension->getTemplate());
    }

    /**
     * Test if Twig extension returns proper functions.
     */
    public function testGetFunctions()
    {
        $extension = new CategoryExtension(null);

        $expectedFunctionsNames = ['category_tree', 'render_tree', 'category_child_tree'];
        $actualFunctionNames = array_keys($extension->getFunctions());

        $this->assertEquals($expectedFunctionsNames, $actualFunctionNames);
    }

    /**
     * Tests renderCategoryTree().
     */
    public function testRenderCategoryTree()
    {
        $tree = [1];
        $template = 'testTemplate';
        $expected = 'testStr';

        /** @var Twig_Environment|\PHPUnit_Framework_MockObject_MockObject $environment */
        $environment = $this->getMock('Twig_Environment', ['render']);
        $environment->expects($this->once())
            ->method('render')
            ->with(
                $template,
                [
                    'categories' => $tree,
                    'selected_category' => null,
                    'current_category' => null,
                ]
            )
            ->will($this->returnValue($expected));

        $extension = new CategoryExtension(null);
        $extension->setTemplate($template);

        $this->assertEquals($expected, $extension->renderCategoryTree($environment, $tree));

        $this->assertNull($extension->renderCategoryTree($environment, []));
    }

    /**
     * Tests getCategoryTree().
     */
    public function testGetCategoryTree()
    {
        $maxLevel = 10;
        $template = 'testTemplate';
        $expected = 'testStr';
        $tree = [1];
        $categoryDocument = new \stdClass();

        /** @var Twig_Environment|\PHPUnit_Framework_MockObject_MockObject $environment */
        $environment = $this->getMock('Twig_Environment', ['render']);
        $environment->expects($this->once())
            ->method('render')
            ->with(
                $template,
                [
                    'categories' => $tree,
                    'selected_category' => null,
                    'current_category' => $categoryDocument,
                ]
            )
            ->will($this->returnValue($expected));

        /** @var CategoryService|\PHPUnit_Framework_MockObject_MockObject $service */
        $service = $this->getMock('stdClass', ['getTree', 'setCurrentCategoryId', 'getCurrentCategoryDocument']);
        $service->expects($this->once())->method('getTree')->with($maxLevel)->will($this->returnValue($tree));
        $service->expects($this->once())->method('getCurrentCategoryDocument')->will(
            $this->returnValue($categoryDocument)
        );

        $extension = new CategoryExtension($service);

        $this->assertEquals($expected, $extension->getCategoryTree($environment, $template, $maxLevel));
    }

    /**
     * Tests getCategoryChildTree().
     */
    public function testGetCategoryChildTree()
    {
        $maxLevel = 10;
        $template = 'testTemplate';
        $expected = 'testStr';
        $selectedCategory = 'selectedCategory';
        $fromCategory = 'fromCategory';
        $tree = [1];
        $categoryDocument = new \stdClass();

        /** @var \Twig_Environment|\PHPUnit_Framework_MockObject_MockObject $environment */
        $environment = $this->getMock('Twig_Environment', ['render']);
        $environment->expects($this->once())
            ->method('render')
            ->with(
                $template,
                [
                    'categories' => $tree,
                    'selected_category' => $selectedCategory,
                    'current_category' => $categoryDocument,
                ]
            )
            ->will($this->returnValue($expected));

        /** @var CategoryService|\PHPUnit_Framework_MockObject_MockObject $service */
        $service = $this->getMock('stdClass', ['getPartialTree', 'setCurrentCategoryId', 'getCurrentCategoryDocument']);

        $service->expects($this->once())
            ->method('getPartialTree')
            ->with($maxLevel, $fromCategory)
            ->will($this->returnValue($tree));

        $service->expects($this->once())
            ->method('getCurrentCategoryDocument')
            ->will(
                $this->returnValue($categoryDocument)
            );

        $extension = new CategoryExtension($service);

        $this->assertEquals(
            $expected,
            $extension->getCategoryChildTree(
                $environment,
                $template,
                $maxLevel,
                $selectedCategory,
                $fromCategory
            )
        );
    }
}
