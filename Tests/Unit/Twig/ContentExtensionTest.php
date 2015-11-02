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

use ONGR\ContentBundle\Twig\ContentExtension;
use ONGR\ElasticsearchBundle\Service\Manager;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Symfony\Component\Routing\RouterInterface;

/**
 * Provides tests for content extension.
 */
class ContentExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getName function.
     */
    public function testGetName()
    {
        $extension = $this->getContentExtension([]);
        $this->assertEquals($extension->getName(), 'content_extension');
    }

    /**
     * Test getFunctions.
     */
    public function testGetFunctions()
    {
        $extension = $this->getContentExtension([]);

        foreach ($extension->getFunctions() as $function => $object) {
            switch ($function) {
                case 'snippet':
                case 'getContentsBySlugs':
                    $this->assertFalse($object->needsEnvironment());
                    break;
                default:
                    $this->assertTrue($object->needsEnvironment());
                    break;
            }
            $this->assertTrue(method_exists($extension, $function . 'Function'));
        }
    }

    /**
     * Function test.
     */
    public function testGetContentsBySlugsFunction()
    {
        $document = new \stdClass();
        $document->slug = 1;
        $document->title = 'testTitle';
        $document->content = 'testContent';

        $document2 = new \stdClass();
        $document2->slug = 2;
        $document2->title = 'testTitle2';
        $document2->content = 'testContent2';

        $extension = $this->getContentExtension([$document2, $document]);

        $this->assertEquals([$document, $document2], $extension->getContentsBySlugsFunction([1, 2], true));
    }

    /**
     * Test data provider for testSnippetFunction().
     *
     * @return array
     */
    public function getTestSnippetFunctionData()
    {
        $out = [];

        // Case #0: inline strategy.
        $out[] = ['inline'];

        // Case #1: esi strategy.
        $out[] = ['esi'];

        // Case #2: ssi strategy.
        $out[] = ['ssi'];

        return $out;
    }

    /**
     * Tests whether extension is called with correct parameters.
     *
     * @param string $strategy
     *
     * @dataProvider    getTestSnippetFunctionData()
     */
    public function testSnippetFunction($strategy)
    {
        $router = $this->getRouterMock();

        $fragmentHandlerMock = $this->getFragmentHandlerMock();
        $fragmentHandlerMock
            ->expects($this->exactly(1))
            ->method('render')
            ->with(
                $this->anything(),
                $strategy
            );

        $document = new \stdClass();
        $document->slug = 1;
        $document->title = 'testTitle';
        $document->content = 'testContent';

        $extension = new ContentExtension(
            $fragmentHandlerMock,
            $router,
            $strategy,
            $this->getManager([$document]),
            'AcmeTestBundle:Content'
        );

        $extension->snippetFunction(1);
    }

    /**
     * Tests extension when exception is thrown.
     */
    public function testSnippetFunctionWithException()
    {
        $router = $this->getRouterMock();
        $router
            ->expects($this->once())
            ->method('generate')
            ->with(
                '_ongr_plain_cms_snippet',
                [
                    'template' => null,
                    'slug' => 1,
                ]
            );

        $fragmentHandlerMock = $this->getFragmentHandlerMock();
        $fragmentHandlerMock
            ->expects($this->at(0))
            ->method('render')
            ->with(
                $this->anything(),
                []
            )->will($this->throwException(new \InvalidArgumentException()));
        $fragmentHandlerMock
            ->expects($this->at(1))
            ->method('render')
            ->with(
                $this->anything()
            )->will($this->returnValue('content'));

        $extension = new ContentExtension(
            $fragmentHandlerMock,
            $router,
            [],
            $this->getManager(),
            'AcmeTestBundle:Content'
        );

        $this->assertEquals('content', $extension->snippetFunction(1));
    }

    /**
     * @param array $results
     *
     * @return ContentExtension
     */
    protected function getContentExtension($results = [])
    {
        $extension = new ContentExtension(
            $this->getFragmentHandlerMock(),
            $this->getRouterMock(),
            null,
            $this->getManager($results)->getRepository('AcmeTestBundle:Content')
        );

        return $extension;
    }

    /**
     * Returns Manager mock.
     *
     * @param array $result
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Manager
     */
    protected function getManager($result = [])
    {
        $manager = $this->getMockBuilder('ONGR\ElasticsearchBundle\Service\Manager')
            ->disableOriginalConstructor()
            ->getMock();

        $repository = $this->getMockBuilder('ONGR\ElasticsearchBundle\Service\Repository')
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMock();

        $repository->expects($this->any())
            ->method('execute')
            ->willReturn($result);

        $manager->expects($this->any())
            ->method('getRepository')
            ->with('AcmeTestBundle:Content')
            ->willReturn($repository);

        return $manager;
    }

    /**
     * @return FragmentHandler|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getFragmentHandlerMock()
    {
        return $this->getMock(
            'Symfony\Component\HttpKernel\Fragment\FragmentHandler',
            ['render']
        );
    }

    /**
     * @return RouterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRouterMock()
    {
        return $this->getMock('Symfony\Component\Routing\RouterInterface');
    }
}
