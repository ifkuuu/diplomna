<?php
require_once "app.php";

$optionsService = new \Service\OptionsService($db);

if (isset($_POST['saveBtn'])) {
    try {
        if (isset($_POST['new-category'])) {
            $optionsService->addCategory($_POST['new-category']);
            $_SESSION['msg'] = "Добавянето беше успешно!";
        }
        elseif (isset($_POST['new-subCategory'])) {
            $optionsService->addSubCategory($_POST['new-subCategory'], $_POST['mainCatId']);
            $_SESSION['msg'] = "Добавянето беше успешно!";
        }
        elseif (isset($_POST['new-colour'])) {
            $optionsService->addColour($_POST['new-colour']);
            $_SESSION['msg'] = "Добавянето беше успешно!";
        }
        elseif (isset($_POST['new-brand'])) {
            $optionsService->addBrand($_POST['new-brand']);
            $_SESSION['msg'] = "Добавянето беше успешно!";
        }
        elseif (isset($_POST['new-size'])) {
            $optionsService->addSize($_POST['new-size'], $_POST['mainCatId']);
            $_SESSION['msg'] = "Добавянето беше успешно!";
        }
        elseif (isset($_POST['redact-subCategory'])) {
            $optionsService->redactSubCategory($_POST['redact-subCategory'], $_POST['subCategory']);
            $_SESSION['msg'] = "Редакцията беше успешна!";
        }
        elseif (isset($_POST['redact-category'])) {
            $optionsService->redactCategory($_POST['redact-category'], $_POST['category']);
            $_SESSION['msg'] = "Редакцията беше успешна!";
        }
        elseif (isset($_POST['redact-colour'])) {
            $optionsService->redactColour($_POST['redact-colour'], $_POST['colour']);
            $_SESSION['msg'] = "Редакцията беше успешна!";
        }
        elseif (isset($_POST['redact-brand'])) {
            $optionsService->redactBrand($_POST['redact-brand'], $_POST['brand']);
            $_SESSION['msg'] = "Редакцията беше успешна!";
        }
        elseif (isset($_POST['redact-size'])) {
            $optionsService->redactSize($_POST['redact-size'], $_POST['size'][0]);
            $_SESSION['msg'] = "Редакцията беше успешна!";
        }
    } catch (Exception $e) {
        $errorMessage =  $e->getMessage();
    }
}


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

include 'frontend/admin_add_options_frontend.php';
