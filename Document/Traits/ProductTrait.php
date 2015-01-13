<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Document\Traits;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Trait used for documents which require Product standard fields.
 *
 * @deprecated Will be removed in stable version. Use AbstractProductDocument instead.
 */
trait ProductTrait
{
    /**
     * @var string
     *
     * @ES\Property(type="string", name="title", fields={@ES\MultiField(name="raw", type="string")})
     */
    private $title;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="description")
     */
    private $description;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="long_description")
     */
    private $longDescription;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="sku")
     */
    private $sku;

    /**
     * @var float
     *
     * @ES\Property(type="float", name="price")
     */
    private $price;

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
