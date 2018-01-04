<?php
require_once "app.php";

try {
    $data = $productService->getNewestProductsViewData();
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}

include_once "frontend/homepage_frontend.php";
