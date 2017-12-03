<?php
require_once 'app.php';

$productService = new \Service\ProductService($db);
$product = $productService->getProductInfo(6);
var_dump($product->getBrandInfo()->getId(), $product->getBrandInfo()->getBrand());
var_dump($product->getCategoryInfo()->getCategory());
var_dump($product->getSubCategoryInfo()->getSubCategory());
var_dump($product->getGenderInfo()->getId(), $product->getGenderInfo()->getGender());
var_dump($product->getColourInfo()->getColour());
foreach ($product->getSizeInfo() as $size) {
    var_dump($size->getSize());
}
foreach ($product->getImages() as $image) {
    var_dump($image);
}

var_dump($product->getPrice(), $product->getDescription(), $product->getName());
