<?php

namespace Service;


interface ProductServiceInterface
{
    public function addProduct( string $name,
                                float $price,
                                array $quantity,
                                int $categoryId,
                                int $subCategoryId,
                                int $brandId,
                                int $genderId,
                                array $sizeId,
                                int $colourId,
                                string $description = null,
                                array $picturePath = null);

    public function getAllProductsViewData();

    public function getProductInfo(int $id);

    public function updateProductStock(int $id, int $quantity);

    public function search(string $searchText);

    /**
     * @param int $productVariantId The current variant being viewed.
     * @param int $colourId
     * @param int $sizeId
     * @return mixed Returns the variant id corresponding to the above 3 params.
     */
    public function getVariantIdByColourAndSize(int $productVariantId, int $colourId, int $sizeId);

    public function getNewestProductsViewData();
}
