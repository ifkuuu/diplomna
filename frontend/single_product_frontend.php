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
                        <form action="">
                            <input type="text" placeholder="Какво търсиш днес?">
                            <input type="submit" value="Търсене">
                        </form>
                    </div>

<!--                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Products</h2>
                        <div class="thubmnail-recent">
                            <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                            <h2><a href="">Sony Smart TV - 2015</a></h2>
                            <div class="product-sidebar-price">
                                <ins>$700.00</ins> <del>$800.00</del>
                            </div>
                        </div>
                        <div class="thubmnail-recent">
                            <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                            <h2><a href="">Sony Smart TV - 2015</a></h2>
                            <div class="product-sidebar-price">
                                <ins>$700.00</ins> <del>$800.00</del>
                            </div>
                        </div>
                        <div class="thubmnail-recent">
                            <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                            <h2><a href="">Sony Smart TV - 2015</a></h2>
                            <div class="product-sidebar-price">
                                <ins>$700.00</ins> <del>$800.00</del>
                            </div>
                        </div>
                        <div class="thubmnail-recent">
                            <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                            <h2><a href="">Sony Smart TV - 2015</a></h2>
                            <div class="product-sidebar-price">
                                <ins>$700.00</ins> <del>$800.00</del>
                            </div>
                        </div>
                    </div>-->

<!--                    <div class="single-sidebar">-->
<!--                        <h2 class="sidebar-title">Recent Posts</h2>-->
<!--                        <ul>-->
<!--                            <li><a href="">Sony Smart TV - 2015</a></li>-->
<!--                            <li><a href="">Sony Smart TV - 2015</a></li>-->
<!--                            <li><a href="">Sony Smart TV - 2015</a></li>-->
<!--                            <li><a href="">Sony Smart TV - 2015</a></li>-->
<!--                            <li><a href="">Sony Smart TV - 2015</a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
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
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="<?= $product->getMainImage()->getImageUrl() ?>" alt="">
                                    </div>

                                    <div class="product-gallery">
                                        <?php foreach ($images as $image): ?>
                                        <img  class="ivo-related-image" src="<?= $image->getImageUrl() ?>" alt="">
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

                                    <form action="" class="cart">
                                        <div class="sizes">
                                            <label for="product-sizes">Избери размер  </label>
                                            <select id="product-sizes" name="size">
                                                    <option value="-1">- Размер -</option>
                                                <?php foreach ($sizes as $size): ?>
                                                    <option value="<?= $size->getId() ?>"><?= $size->getSize() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="sizes">
                                            <label for="product-colours">Избери цвят  </label>
                                            <select id="product-colours" name="colour">
                                                <option value="-1">- Цвят -</option>
                                                <?php foreach ($colours as $colour): ?>
                                                    <option value="<?= $colour->getId() ?>"><?= $colour->getColour() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="quantity">
                                            <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" min="1" step="1">
                                        </div>
                                        <button class="add_to_cart_button" type="submit">Добави в количката</button>
                                    </form>

<!--                                    <div class="product-inner-category">
                                        <p>Category: <a href="">Summer</a>. Tags: <a href="">awesome</a>, <a href="">best</a>, <a href="">sale</a>, <a href="">shoes</a>. </p>
                                    </div>-->

                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Описание</a></li>
                                            <!--<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Оценки</a></li>-->
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <h2>Описание на продукта</h2>
                                                <p><?= $product->getDescription() ?></p>
                                            </div>
  <!--                                          <div role="tabpanel" class="tab-pane fade" id="profile">
                                                <h2>Reviews</h2>
                                                <div class="submit-review">
                                                    <p><label for="name">Name</label> <input name="name" type="text"></p>
                                                    <p><label for="email">Email</label> <input name="email" type="email"></p>
                                                    <div class="rating-chooser">
                                                        <p>Your rating</p>

                                                        <div class="rating-wrap-post">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <p><label for="review">Your review</label> <textarea name="review" id="" cols="30" rows="10"></textarea></p>
                                                    <p><input type="submit" value="Submit"></p>
                                                </div>
                                            </div>-->
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
                                            <a href="" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Добави</a>
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
