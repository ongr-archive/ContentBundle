<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\app\fixture\Acme\TestBundle\Document;

use ONGR\ContentBundle\Document\AbstractProductDocument;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Dummy product document.
 *
 * @ES\Document(type="product")
 */
class Product extends AbstractProductDocument
{
}
