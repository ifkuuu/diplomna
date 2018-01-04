<?php
require_once 'app.php';

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

//mail('ivelinenchev@abv.bg', 'Subjectche', 'suobshtenie', 'FROM: ivo@gmail.com');
//$userService = new \Service\UserService($db, $validatorService, $encryptionService);
//$test = new \Service\Orders\OrdersService($db, $productService, $userService);
//$asd = $test->getOrder(16);
//var_dump($asd);
//$test->getAllOrders(1);
//$mailz = new \Service\Mail\MailService();
//$mailz->sendOrderInfoEmail($asd);
$productService->getNewestProductsViewData();
