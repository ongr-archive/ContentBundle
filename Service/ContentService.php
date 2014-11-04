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
use ONGR\ElasticsearchBundle\ORM\Repository;
use Psr\Log\LoggerAwareTrait;

/**
 * Content management service.
 */
class ContentService
{
    use LoggerAwareTrait;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @param Repository $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieves document by slug.
     *
     * @param string $slug
     *
     * @return DocumentInterface|null
     */
    public function getDocumentBySlug($slug)
    {
        $search = $this->repository->createSearch();
        $search->addQuery(new TermQuery('slug', $slug), 'must');

        $results = $this->repository->execute($search);

        if ($results->count()) {
            return $results->current();
        }

        return null;
    }

    /**
     * Returns data for content snippet render action.
     *
     * @param string $slug
     *
     * @return array
     */
    public function getDataForSnippet($slug)
    {
        $document = $this->getDocumentBySlug($slug);

        if (!$document) {
            $this->logger && $this->logger->warning(
                sprintf("Can not render snippet for '%s' because content was not found.", $slug)
            );

            return ['content' => '', 'title' => null, 'document' => null];
        }

        return [
            'content' => $document->content,
            'title' => $document->title,
            'document' => $document,
        ];
    }
}
