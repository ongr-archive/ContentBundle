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

use ONGR\ContentBundle\Twig\ContentExtension;
use ONGR\ElasticsearchBundle\Test\ElasticsearchTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Symfony\Component\Routing\RouterInterface;

class ContentExtensionsTest extends ElasticsearchTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getDataArray()
    {
        return [
            'default' => [
                'content' => [
                    [
                        '_id' => 'testContent',
                        'slug' => 'testContentSlug',
                        'title' => 'Title',
                        'content' => 'Content of test page',
                        'short_description' => 'Test short description',
                    ],
                ],
            ],
        ];
    }

    /**
     * Test data provider for testSnippetFunction().
     *
     * @return array
     */
    public function getTestSnippetFunctionData()
    {
        $out = [];

        // Case #0: empty request.
        $request = new Request();
        $slug = 'testContentSlug';
        $expectedContent = 'Content of test page';

        $out[] = [$request, $slug, $expectedContent];

        // Case #1: esi request.
        $request = new Request();
        $request->headers->add(
            [
                'Surrogate_Capability' => 'ESI/1.0',
            ]
        );
        $slug = 'testContentSlug';

        $expectedContent = '<esi:include';

        $out[] = [$request, $slug, $expectedContent];

        return $out;
    }

    /**
     * Makes request to snippet route and checks ESI/SSI behavior.
     *
     * @param Request $request
     * @param string  $slug
     * @param string  $expectedContent
     * @param string  $strategy
     *
     * @dataProvider   getTestSnippetFunctionData()
     */
    public function testSnippetFunction($request, $slug, $expectedContent, $strategy = 'esi')
    {
        // Custom logic for Symfony 2.4+.
        if ($this->getContainer()->has('request_stack')) {
            /** @var RequestStack $requestStack */
            $requestStack = $this->getContainer()->get('request_stack');
            $requestStack->push($request);
        }

        /** @var FragmentHandler $handler */
        $handler = $this->getContainer()->get('fragment.handler');
        $handler->setRequest($request);
        /** @var RouterInterface $router */
        $router = $this->getContainer()->get('router');

        $repository = $this->getManager()->getRepository('AcmeTestBundle:Content');

        $extension = new ContentExtension($handler, $router, $strategy, $repository);

        $this->assertContains($expectedContent, $extension->snippetFunction($slug));
    }
}
