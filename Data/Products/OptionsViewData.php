<?php

namespace Data\Products;


use Data\Brand;
use Data\Category;
use Data\Gender;
use Data\Size;
use Data\SubCategory;

class OptionsViewData
{

    /** @var  Gender[] */
    private $genders;

    /** @var  Brand[] */
    private $brands;

    /** @var  Category[] */
    private $categories;

    /** @var  SubCategory[] */
    private $subCategories;

    /** @var  Size[] */
    private $sizes;


    public function getGenders()
    {
        return $this->genders;
    }

    public function setGenders(callable $genders)
    {
        $this->genders = $genders();
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function setBrands(callable $brands)
    {
        $this->brands = $brands();
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories(callable $categories)
    {
        $this->categories = $categories();
    }

    public function getSubCategories()
    {
        return $this->subCategories;
    }

    public function setSubCategories(callable $subCategories)
    {
        $this->subCategories = $subCategories();
    }

    public function getSizes()
    {
        return $this->sizes;
    }

    public function setSizes(callable $sizes)
    {
        $this->sizes = $sizes();
    }
}
