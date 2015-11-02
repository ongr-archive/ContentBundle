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

use ONGR\ElasticsearchDSL\Query\TermsQuery;
use ONGR\ElasticsearchBundle\Service\Repository;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Symfony\Component\Routing\RouterInterface;

/**
 * ContentExtension class.
 */
class ContentExtension extends \Twig_Extension
{
    const NAME = 'content_extension';

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var FragmentHandler
     */
    protected $handler;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var string
     */
    protected $renderStrategy;

    /**
     * @param FragmentHandler $handler
     * @param RouterInterface $router
     * @param string          $renderStrategy
     * @param Repository      $repository
     */
    public function __construct(
        $handler = null,
        RouterInterface $router = null,
        $renderStrategy = null,
        $repository = null
    ) {
        $this->handler = $handler;
        $this->router = $router;
        $this->renderStrategy = $renderStrategy;
        $this->repository = $repository;
    }

    /**
     * Provide a list of helper functions to be used.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            'getContentsBySlugs' => new \Twig_SimpleFunction(
                'getContentsBySlugs',
                [
                    $this,
                    'getContentsBySlugsFunction',
                ],
                [
                    'needs_environment' => false,
                    'is_safe' => ['html'],
                ]
            ),
            'snippet' => new \Twig_SimpleFunction(
                'snippet',
                [
                    $this,
                    'snippetFunction',
                ],
                [
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }

    /**
     * Return an array with content documents filtered by slugs array.
     *
     * @param array $slugs
     * @param bool  $keepOrder
     *
     * @return mixed
     */
    public function getContentsBySlugsFunction($slugs, $keepOrder = false)
    {
        $search = $this->repository->createSearch();
        $search->addQuery(new TermsQuery('slug', $slugs), 'should');

        $result = $this->repository->execute($search);

        if ($keepOrder) {
            $orderedResult = [];
            foreach ($slugs as $slug) {
                foreach ($result as $document) {
                    if ($document->slug == $slug) {
                        $orderedResult[] = $document;
                    }
                }
            }

            $result = $orderedResult;
        }

        return $result;
    }

    /**
     * Renders content by given slug.
     *
     * @param string      $slug
     * @param bool|string $template
     *
     * @return string
     */
    public function snippetFunction(
        $slug,
        $template = null
    ) {
        $result = null;
        if ($this->handler && $this->router) {
            $route = $this->router->generate(
                '_ongr_plain_cms_snippet',
                [
                    'slug' => $slug,
                    'template' => $template,
                ]
            );
            try {
                $result = $this->handler->render($route, $this->renderStrategy);
            } catch (\InvalidArgumentException $ex) {
                // ESI is disabled.
                $result = $this->handler->render($route);
            }
        }

        return $result;
    }

    /**
     * Get name of the twig extension.
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
