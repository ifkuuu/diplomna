<?php
require_once "app.php";

if (isset($_GET['colour']) && isset($_GET['product']) && !isset($_GET['size'])) {
    $result = $productService->filterSizesByIdAndColour($_GET['product'], $_GET['colour']);
    echo json_encode($result);
}

if (isset($_GET['size'])) {
    $result = $productService->getVariantIdByColourAndSize($_GET['product'], $_GET['colour'], $_GET['size']);
    echo $result;
}
