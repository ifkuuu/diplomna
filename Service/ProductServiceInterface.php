<?php

namespace Service;


interface ProductServiceInterface
{
    public function addProduct( string $name,
                                float $price,
                                int $quantity,
                                int $categoryId,
                                int $subCategoryId,
                                int $brandId,
                                int $genderId,
                                int $sizeId,
                                int $colourId,
                                string $description = null,
                                string $picturePath = null);

    public function getAllProductsViewData();

    public function getProductInfo(int $id);
}