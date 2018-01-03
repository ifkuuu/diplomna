<?php
require_once "app.php";

if (isset($_GET['product'])) {
    $currentProduct = $_GET['product'];
    $product = $productService->getProductInfo($currentProduct);
    $sizes = $product->getAllSizes();
    $images = $product->getImages();
    $colours = $product->getAllColours();

    /** @var \Data\Products\Product[] $relatedProducts */
    $relatedProducts = $productService->getRelatedProducts($currentProduct);

    include_once "frontend/single_product_frontend.php";
}
