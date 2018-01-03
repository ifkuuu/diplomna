<?php
include_once "header_frontend.php";
/** @var $product \Data\Products\Product The Main Product*/
/** @var $images \Data\Image[] Array of Image[], i.e. all images of the main Product */
/** @var $relatedProducts \Data\Products\Product[] Related Products to the Main one*/
/** @var $sizes \Data\Size[] Main Product's available sizes */
/** @var $colours \Data\Colour[] Main Product's available colours */
?>

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Магазин</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Търси Продукти</h2>
                        <form action="search.php" method="post">
                            <input type="text" placeholder="Какво търсиш днес?" name="search-text">
                            <input type="submit" value="Търсене" name="search-submit">
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="product-breadcroumb">
                            <a href="all_products.php">Всички</a>
                            <a href="all_products.php?gender=<?= $product->getGenderInfo()->getId() ?>">
                                <?= $product->getGenderInfo()->getGender() ?>
                            </a>
                            <a href="all_products.php?gender=<?= $product->getGenderInfo()->getId() ?>&cat=<?= $product->getCategoryInfo()->getId() ?>">
                                <?= $product->getCategoryInfo()->getCategory() ?>
                            </a>
                            <a href="all_products.php?gender=<?= $product->getGenderInfo()->getId() ?>&cat=<?= $product->getCategoryInfo()->getId() ?>&subCat=<?= $product->getSubCategoryInfo()->getId()?>">
                                <?= $product->getSubCategoryInfo()->getSubCategory() ?>
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div id="product-images" class="product-images">
                                    <div class="product-main-img">
                                        <img id="ivo-product-main-img" src="<?= $product->getMainImage()->getImageUrl() ?>" alt="">
                                    </div>

                                    <div class="product-gallery">
                                        <?php foreach ($images as $image): ?>
                                        <a href="<?= $image->getImageUrl() ?>" data-fancybox="gallery">
                                            <img  class="ivo-related-image" src="<?= $image->getImageUrl() ?>" alt="">
                                        </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="product-inner">
                                    <h2 class="product-name"><?= $product->getName() . ', ' . $product->getSizeInfo()->getSize() . ', ' . $product->getColourInfo()->getColour() ?></h2>
                                    <div class="product-inner-price">
                                        <?php if ($product->getDiscountedPrice() === null): ?>
                                        <ins><?= $product->getPrice() ?> лв.</ins>
                                        <?php else: ?>
                                        <ins><?= $product->getDiscountedPrice() ?> лв.</ins> <del><?= $product->getPrice() ?> лв.</del>
                                        <?php endif; ?>
                                    </div>

                                    <form action="cart.php" method="post" class="cart">
                                        <div class="sizes">
                                            <label for="product-colours">Избери цвят  </label>
                                            <select id="product-colours" name="colour">
                                                <option value="-1">- Избери цвят -</option>
                                                <?php foreach ($colours as $colour): ?>
<!--                                                    --><?php //if ($colour->getId() != $product->getColourInfo()->getId()): ?>
                                                        <option value="<?= $colour->getId() ?>"><?= $colour->getColour(); ?></option>
<!--                                                    --><?php //endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="sizes">
                                            <label for="product-sizes">Избери размер  </label>
                                            <select id="product-sizes" name="size">
<!--                                                <option value="--><?//= $product->getSizeInfo()->getId() ?><!--">--><?//= $product->getSizeInfo()->getSize() ?><!--</option>-->
                                                <option value="-1">- Избери размер -</option>
                                                <?php foreach ($sizes as $size): ?>
                                                    <?php if ($size->getId() != $product->getSizeInfo()->getId()): ?>
                                                        <option value="<?= $size->getId() ?>"><?= $size->getSize() ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="quantity">
                                            <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" min="1" step="1">
                                        </div>
                                        <button class="add_to_cart_button" type="submit" name="addToCart" value="<?= $product->getId(); ?>">Добави в количката</button>
                                    </form>

                                    <?php if (isset($_SESSION['errorMessage'])): ?>
                                        <div class="ivo-has-error">
                                            <?= $_SESSION['errorMessage'] ?>
                                        </div>
                                    <?php unset($_SESSION['errorMessage']); endif; ?>

                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Описание</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <h2>Описание на продукта</h2>
                                                <p><?= $product->getDescription() ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="related-products-wrapper">
                            <h2 class="related-products-title">Подобни продукти</h2>
                            <div class="related-products-carousel">
                                <?php foreach ($relatedProducts as $relatedProduct): ?>
                                <div class="single-product" id="ivo-single-product">
                                    <div class="product-f-image ivo-related-div">
                                        <img class="ivo-related-image" src="<?= $relatedProduct->getMainImage()->getImageUrl() ?>" alt="">
                                        <div class="product-hover">
                                            <a href="cart.php?product=<?= $relatedProduct->getId()?>" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Добави</a>
                                            <a href="single_product.php?product=<?= $relatedProduct->getId() ?>" class="view-details-link"><i class="fa fa-link"></i> Виж детайли</a>
                                        </div>
                                    </div>

                                    <h2><a href=""><?= $relatedProduct->getName() . ', ' . $relatedProduct->getGenderInfo()->getGender() . ', ' . $relatedProduct->getColourInfo()->getColour() ?></a></h2>

                                    <div class="product-carousel-price">
                                        <?php if ($relatedProduct->getDiscountedPrice() === null): ?>
                                            <ins><?= $relatedProduct->getPrice() ?> лв.</ins>
                                        <?php else: ?>
                                            <ins><?= $relatedProduct->getDiscountedPrice() ?> лв.</ins> <del><?= $relatedProduct->getPrice() ?> лв.</del>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php include_once "footer_frontend.php";
