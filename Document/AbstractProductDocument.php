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
use ONGR\RouterBundle\Document\SeoAwareInterface;
use ONGR\RouterBundle\Document\SeoAwareTrait;
use ONGR\ElasticsearchBundle\Document\AbstractDocument;

/**
 * Product document with standard fields.
 *
 * @ES\Document(create=false)
 */
abstract class AbstractProductDocument extends AbstractDocument implements SeoAwareInterface
{
    use SeoAwareTrait;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="title", fields={@ES\MultiField(name="raw", type="string")})
     */
    protected $title;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="description")
     */
    protected $description;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="long_description")
     */
    protected $longDescription;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="sku")
     */
    protected $sku;

    /**
     * @var float
     *
     * @ES\Property(type="float", name="price")
     */
    protected $price;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @param string $longDescription
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }
}
