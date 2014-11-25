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
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchBundle\Document\DocumentTrait;

/**
 * Product document.
 *
 * @ES\Document(type="product")
 */
class Product implements DocumentInterface
{
    use DocumentTrait;

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
     * @var float
     *
     * @ES\Property(type="float", name="price")
     */
    private $price;

    /**
     * @var string
     *
     * @ES\Property(type="geo_point", name="location")
     */
    private $location;

    /**
     * @var UrlObject[]|\Iterator
     *
     * @ES\Property(type="object", objectName="ONGRContentBundle:UrlObject", multiple=true, name="url")
     */
    private $links;

    /**
     * @var ImagesNested[]|\Iterator
     *
     * @ES\Property(type="nested", objectName="ONGRContentBundle:ImagesNested", multiple=true, name="images")
     */
    private $images;

    /**
     * @var Category[]|\Iterator
     *
     * @ES\Property(type="object", objectName="ONGRContentBundle:Category", multiple=true, name="categories")
     */
    private $categories;

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
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return \Iterator|UrlObject[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param \Iterator|UrlObject[] $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return \Iterator|ImagesNested[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \Iterator|ImagesNested[] $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return \Iterator|Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \Iterator|Category[] $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }
}
