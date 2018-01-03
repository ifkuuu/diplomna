<?php
require_once "app.php";
/** @var  $queryString */

/* vrushta vsichki produkti i kolko nabroi stranici imame v posledniq si element*/
/** @var \Data\Products\AllProductsViewData[] $allProductsViewData */
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$allProductsViewData = $productService->getAllProductsViewData();
$totalPages = array_pop($allProductsViewData);
if ($currentPage > $totalPages) {
    header("Location: all_products.php?page={$totalPages}&{$queryString}");
}
if ($currentPage <= 0) {
    header("Location: all_products.php?page=1&{$queryString}");
}
include_once "frontend/all_products_frontend.php";
