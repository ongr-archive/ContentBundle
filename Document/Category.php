<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Document;

use ONGR\ContentBundle\Document\Traits\CategoryTrait;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchBundle\Document\DocumentTrait;

/**
 * Category document.
 *
 * @ES\Document(type="category")
 */
class Category implements DocumentInterface
{
    use CategoryTrait;
    use DocumentTrait;
}
