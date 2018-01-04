<?php
include_once "header_frontend.php";
/** @var $data \Data\Products\Product[] */
?>

<?php if (isset($errorMessage)): ?>
    <div class="ivo-has-error">
        <?= $errorMessage ?>
    </div>
<?php endif; ?>

    <div class="slider-area">
        <div class="zigzag-bottom"></div>
        <div id="slide-list" class="carousel carousel-fade slide" data-ride="carousel">
            
            <div class="slide-bulletz">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ol class="carousel-indicators slide-indicators">
                                <li data-target="#slide-list" data-slide-to="0" class="active"></li>
                                <li data-target="#slide-list" data-slide-to="1"></li>
                                <li data-target="#slide-list" data-slide-to="2"></li>
                            </ol>                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="single-slide">
                        <div class="slide-bg slide-one"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>Добре дошли</h2>
                                                <p>Добре дошли в Ivo's Abyss!</p>
                                                <p>Електронен магазин.</p>
                                                <a href="about.php" class="readmore">Научи повече</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-slide">
                        <div class="slide-bg slide-two"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>Нови продукти</h2>
                                                <p>Виж последните 5 продукта!</p>
                                                <a href="#latest-products" class="readmore">Виж</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-slide">
                        <div class="slide-bg slide-three"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>We are superb</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores, eius?</p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptates necessitatibus dicta recusandae quae amet nobis sapiente explicabo voluptatibus rerum nihil quas saepe, tempore error odio quam obcaecati suscipit sequi.</p>
                                                <a href="#" class="readmore">Learn more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>        
    </div> <!-- End slider area -->
    
    <div class="promo-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="single-promo">
                        <i class="fa fa-refresh"></i>
                        <p>30 Дни право на връшане</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="single-promo">
                        <i class="fa fa-truck"></i>
                        <p>Безплатна доставка</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="single-promo">
                        <i class="fa fa-gift"></i>
                        <p>Нови и модерни продукти</p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End promo area -->
    
    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest-product" id="latest-products">
                        <h2 class="section-title">Най-нови продукти</h2>
                        <div class="product-carousel">
                            <?php foreach ($data as $product): ?>
                                <div class="single-product" id="ivo-single-product">
                                    <div class="product-f-image ivo-related-div">
                                        <img class="ivo-related-image" src="<?= $product->getMainImage()->getImageUrl() ?>" alt="">
                                        <div class="product-hover">
                                            <a href="cart.php?product=<?= $product->getId()?>" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Добави</a>
                                            <a href="single_product.php?product=<?= $product->getId() ?>" class="view-details-link"><i class="fa fa-link"></i> Виж детайли</a>
                                        </div>
                                    </div>

                                    <h2><a href=""><?= $product->getName() . ', ' . $product->getGenderInfo()->getGender() . ', ' . $product->getColourInfo()->getColour() ?></a></h2>

                                    <div class="product-carousel-price">
                                        <?php if ($product->getDiscountedPrice() === null): ?>
                                            <ins><?= $product->getPrice() ?> лв.</ins>
                                        <?php else: ?>
                                            <ins><?= $product->getDiscountedPrice() ?> лв.</ins> <del><?= $product->getPrice() ?> лв.</del>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->
    
    <div class="brands-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="brand-wrapper">
                        <h2 class="section-title">Марки</h2>
                        <div class="brand-list">
                            <img src="images/logos/adidas-logo.png" alt="">
                            <img src="images/logos/converse-logo.png" alt="">
                            <img src="images/logos/nike-logo.png" alt="">
                            <img src="images/logos/vans-logo.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End brands area -->
    
<?php
include_once "footer_frontend.php";
