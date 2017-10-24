<?php
include_once "header_frontend.php";
/** @var \Data\Products\AllProductsViewData[] $allProductsViewData */
/** @var string|int $currentPage The current page from $_GET['page'] */
/** @var int $totalPages  The total pages, resulting from our allProductsViewData query */
/** @var string $queryString $_SERVER['QUERY_STRINGS'] */
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



<div class="row">
    <div class="col-md-12">
        <div class="product-pagination text-center">
            <nav>
                <ul class="pagination" id="ivo-pagination">
                    <li>
                        <a href="?page=1" aria-label="Previous">
                            <span aria-hidden="true">1 &laquo;</span>
                        </a>
                    </li>
                        <?php if ($currentPage-2 == 0): ?>
                            <li><a href="?page=<?= $currentPage-1 . '&' .$queryString ?>"><?= $currentPage-1 ?></a></li>
                        <?php elseif ($currentPage-2 > 0): ?>
                            <li><a href="?page=<?= $currentPage-2 . '&' .$queryString ?>"><?= $currentPage-2 ?></a></li>
                            <li><a href="?page=<?= $currentPage-1 . '&' .$queryString ?>"><?= $currentPage-1 ?></a></li>
                        <?php endif; ?>
                    <?php if ($currentPage <= $totalPages): ?>
                        <li><a class="ivo-selected" href="?page=<?= $currentPage . '&' .$queryString ?>"><?= $currentPage ?></a></li>
                        <?php if ($currentPage <= $totalPages-1): ?>
                            <li><a href="?page=<?= $currentPage+1 . '&' .$queryString ?>"><?= $currentPage+1 ?></a></li>
                            <?php if ($currentPage < $totalPages-1): ?>
                                <li><a href="?page=<?= $currentPage+2 . '&' .$queryString ?>"><?= $currentPage+2 ?></a></li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <li>
                        <a href="?page=<?= $totalPages ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo; <?= $totalPages ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div id="ivo-products" class="row">
            <?php foreach ($allProductsViewData as $product): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <div class="product-upper ivo-related-div">
                            <a href="single_product.php?product=<?= $product->getProductVariantId() ?>"><img class="ivo-related-image" src="<?= $product->getImageUrl() ?>" alt=""></a>
                        </div>
                        <h2><a href="single_product.php?product=<?= $product->getProductVariantId() ?>">
                                <?= $product->getProductName() . ', '
                                . $product->getBrand() . ', '
                                . $product->getGender() ?></a></h2>
                        <div class="product-carousel-price">
                            <?php if ($product->getDiscountedPrice() !== null): ?>
                                <ins><?= $product->getDiscountedPrice() ?> лв.</ins> <del><?= $product->getPrice() ?> лв.</del>
                            <?php  else: ?>
                                <ins><?= $product->getPrice() ?> лв.</ins>
                            <?php endif; ?>
                        </div>

                        <div class="product-option-shop">
                            <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70" rel="nofollow" href="/canvas/shop/?add-to-cart=70">Add to cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="product-pagination text-center">
                    <nav>
                        <ul class="pagination" id="ivo-pagination">
                            <li>
                                <a href="?page=1" aria-label="Previous">
                                    <span aria-hidden="true">1 &laquo;</span>
                                </a>
                            </li>
                                <?php if ($currentPage-2 == 0): ?>
                                    <li><a href="?page=<?= $currentPage-1 . '&' .$queryString ?>"><?= $currentPage-1 ?></a></li>
                                <?php elseif ($currentPage-2 > 0): ?>
                                    <li><a href="?page=<?= $currentPage-2 . '&' .$queryString ?>"><?= $currentPage-2 ?></a></li>
                                    <li><a href="?page=<?= $currentPage-1 . '&' .$queryString ?>"><?= $currentPage-1 ?></a></li>
                                <?php endif; ?>
                                <?php if ($currentPage <= $totalPages): ?>
                                    <li><a class="ivo-selected" href="?page=<?= $currentPage . '&' .$queryString ?>"><?= $currentPage ?></a></li>
                                    <?php if ($currentPage <= $totalPages-1): ?>
                                        <li><a href="?page=<?= $currentPage+1 . '&' .$queryString ?>"><?= $currentPage+1 ?></a></li>
                                        <?php if ($currentPage < $totalPages-1): ?>
                                        <li><a href="?page=<?= $currentPage+2 . '&' .$queryString ?>"><?= $currentPage+2 ?></a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <li>
                                <a href="?page=<?= $totalPages ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo; <?= $totalPages ?></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once "footer_frontend.php";
?>
