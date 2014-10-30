<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Service;

use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchBundle\DSL\Query\TermQuery;
use ONGR\ElasticsearchBundle\DSL\Search;
use ONGR\ElasticsearchBundle\ORM\Repository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Collects categories and products data.
 */
class CategoryList
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var int
     */
    protected $productsPerPage;

    /**
     * @param Request           $request
     * @param DocumentInterface $document
     *
     * @return array
     */
    public function getCategoryData(Request $request, $document)
    {
        $page = max((int)$request->query->get('page'), 1);
        $sort = $request->query->get('sort');
        $reverse = (bool)$request->query->get('desc');

        $search = new Search();
        $search->addQuery(new TermQuery('categories', $document->id), 'must');

        $urlParameters = [
            'document' => $document,
            'sort' => $sort,
            'page' => $page,
        ];

        if ($reverse) {
            $urlParameters['desc'] = 1;
        }

        return [
            'category' => $document,
            'page' => $page,
            'urlParameters' => $urlParameters,
            'urlRoute' => $request->get('_route'),
            'pager' => null,
            'products' => [],
            'count' => 0,
            'js' => $request->isXmlHttpRequest(),
            'selectedCategory' => $document->id,
        ];
    }

    /**
     * @param string $repositoryName
     */
    public function setRepository($repositoryName)
    {
        $this->repository = $this->manager->getRepository($repositoryName);
    }

    /**
     * @param int $productsPerPage
     */
    public function setProductsPerPage($productsPerPage)
    {
        $this->productsPerPage = $productsPerPage;
    }
}
