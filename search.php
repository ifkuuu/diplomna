<?php
require_once "app.php";
/** @var  $queryString */

$allProductsViewData = [];
if (isset($_POST['search-submit'])) {
    $hasBeenSearched = true;
    $allProductsViewData = $productService->search($_POST['search-text']);
}
$isSearch = true;
$totalPages = 1;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

include_once "frontend/all_products_frontend.php";
