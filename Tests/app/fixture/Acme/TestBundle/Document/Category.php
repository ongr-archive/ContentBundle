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

use ONGR\ContentBundle\Document\AbstractCategoryDocument;
use ONGR\ContentBundle\Document\CdnObject;
use ONGR\ContentBundle\Document\ImageNested;
use ONGR\ContentBundle\Document\UrlObject;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Dummy category document.
 *
 * @ES\Document(type="category")
 */
class Category extends AbstractCategoryDocument
{
    /**
     * @var UrlObject[]|\Iterator
     *
     * @ES\Property(name="urls", type="object", objectName="ONGRContentBundle:UrlObject", multiple=true)
     */
    public $dummyUrls;

    /**
     * @var CdnObject[]|\Iterator
     *
     * @ES\Property(name="cdn_urls", type="object", objectName="ONGRContentBundle:CdnObject", multiple=true)
     */
    public $dummyCdnUrls;

    /**
     * @var ImageNested[]|\Iterator
     *
     * @ES\Property(name="images", type="nested", objectName="ONGRContentBundle:ImageNested", multiple=true)
     */
    public $dummyImagesNested;
}
