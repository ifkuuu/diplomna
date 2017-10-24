<?php

namespace Data\Products;


use Data\Brand;
use Data\Category;
use Data\Colour;
use Data\Gender;
use Data\Image;
use Data\Size;
use Data\SubCategory;

class Product
{
    private $id;

    private $name;

    private $price;

    /** @var  Size */
    private $size;

    /** @var  Category */
    private $category;

    /** @var  SubCategory */
    private $subCategory;

    /** @var  Gender */
    private $gender;

    /** @var  Size[] */
    private $sizes;

    /** @var  Brand */
    private $brand;

    /** @var  Colour */
    private $colour;

    /** @var  Image[] */
    private $images;

    private $mainImage;

    private $description;

    private $discountedPrice = null;

    /** @var  Colour[] */
    private $colours;

    /**
     * @return Colour[]
     */
    public function getAllColours()
    {
        return $this->colours;
    }

    /**
     * @param Colour[] $colours
     */
    public function setAllColours(callable $colours)
    {
        $this->colours = $colours();
    }



    /**
     * @return Size
     */
    public function getSizeInfo(): Size
    {
        return $this->size;
    }

    /**
     * @param Size $size
     */
    public function setSizeInfo(Size $size)
    {
        $this->size = $size;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    /**
     * @return Image
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param Image $mainImage
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;
    }



    /**
     * @return null|string
     */
    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    /**
     * @param null $discountedPrice
     */
    public function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = $discountedPrice;
    }



    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return floatval($this->price);
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return Category
     */
    public function getCategoryInfo()
    {
        return $this->category;
    }

    /**
     * @param Category
     */
    public function setCategoryInfo(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return SubCategory
     */
    public function getSubCategoryInfo()
    {
        return $this->subCategory;
    }

    /**
     * @param SubCategory
     */
    public function setSubCategoryInfo(SubCategory $subCategory)
    {
        $this->subCategory = $subCategory;
    }

    /**
     * @return Gender
     */
    public function getGenderInfo()
    {
        return $this->gender;
    }

    /**
     * @param Gender
     */
    public function setGenderInfo(Gender $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return Size[]|\Generator
     */
    public function getAllSizes()
    {
        return $this->sizes;
    }

    /**
     * @param Size
     */
    public function setAllSizes(callable $size)
    {
        $this->sizes = $size();
    }

    /**
     * @return Brand
     */
    public function getBrandInfo()
    {
        return $this->brand;
    }


    public function setBrandInfo(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return Colour
     */
    public function getColourInfo()
    {
        return $this->colour;
    }

    /**
     * @param Colour
     */
    public function setColourInfo(Colour $colour)
    {
        $this->colour = $colour;
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        return $this->images;
    }


    public function setImages(Image $images)
    {
        $this->images[] = $images;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}