<?php

namespace Data\Products;


class AllProductsViewData
{

    private $productVariantId;

    private $productName;

    private $gender;

    private $price;

    private $discountedPrice = null;

    private $imageUrl;

    private $brand;


    /**
     * @return mixed
     */
    public function getProductVariantId()
    {
        return $this->productVariantId;
    }


    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }



    /**
     * @return mixed
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * @return null
     */
    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
}
