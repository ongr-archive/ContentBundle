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

use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\RouterBundle\Document\UrlNested as ParentUrlObject;

/**
 * Object used for documents which require UrlObject standard fields.
 *
 * @ES\Nested
 */
class UrlObject extends ParentUrlObject
{
}
