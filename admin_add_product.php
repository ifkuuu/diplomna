<?php
require_once "app.php";

if (isset($_POST['add'])) {
    $imageUrl = null;
    try {
        if ($_FILES['image']['error'][0] == 0) {
            $uploadService = new \Service\Upload\UploadService();
            $imageUrl = $uploadService->uploadMultipleImages($_FILES['image'], "images");
        }
        $productService = new \Service\ProductService($db);
        $productService->addProduct(
            $_POST['name'],
            $_POST['price'],
            $_POST['quantity'],
            $_POST['category'],
            $_POST['subCategory'],
            $_POST['brand'],
            $_POST['gender'],
            $_POST['size'],
            $_POST['colour'],
            $_POST['description'],
            $imageUrl
        );
        $_SESSION['msg'] = "Продуктът беше добавен успешно!";
    } catch (Exception $e) {
        $errorMessage =  $e->getMessage();
    }
}


$optionsService = new \Service\OptionsService($db);
/** @var \Data\Gender[] $genders */
$genders = $optionsService->getGenders();
/** @var \Data\Brand[] $brands */
$brands = $optionsService->getBrands();
/** @var \Data\Category[] $categories */
$categories = $optionsService->getCategories();
/** @var \Data\SubCategory[] $subCategories */
$subCategories = $optionsService->getSubCategories();
/** @var \Data\Size[] $sizes */
$sizes = $optionsService->getSizes();
/** @var \Data\Colour[] $colours */
$colours = $optionsService->getColours();

include 'frontend/admin_add_product_frontend.php';
