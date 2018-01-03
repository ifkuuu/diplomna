<?php
include_once "header_frontend.php";
/** @var $data \Data\Products\CartViewData */
?>

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Количка за пазаруване</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
    
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <form method="post" action="checkout.php">
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                        <tr>
                                            <th class="product-remove">&nbsp;</th>
                                            <th class="product-thumbnail">&nbsp;</th>
                                            <th class="product-name">Продукт</th>
                                            <th class="product-price">Цена</th>
                                            <th class="product-quantity">Количество</th>
                                            <th class="product-subtotal">Общо</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($data !== false): ?>
                                        <?php foreach ($data->getCartProducts() as $id => $product): ?>
                                            <tr class="cart_item">
                                                <td class="product-remove">
                                                    <a title="Премахнете този продукт" class="remove" href="?remove=<?= $id ?>">×</a>
                                                </td>

                                                <td class="product-thumbnail">
                                                    <a href="single_product.php?product=<?= $product->getId() ?>"><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="<?= $product->getMainImage()->getImageUrl(); ?>"></a>
                                                </td>

                                                <td class="product-name">
                                                    <a href="single_product.php?product=<?= $product->getId() ?>"><?= $product->getName() ?>, размер: <?= $product->getSizeInfo()->getSize() ?></a>
                                                </td>

                                                <td class="product-price">
                                                    <?php if ($product->getDiscountedPrice() !== null): ?>
                                                        <span class="amount"><?= $product->getDiscountedPrice() ?> лв.</span>
                                                    <?php else: ?>
                                                        <span class="amount"><?= $product->getPrice() ?> лв.</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="product-quantity">
                                                    <div class="quantity buttons_added">
                                                       <?= $_SESSION['cartContents'][$id]['qty']; ?>
                                                    </div>
                                                </td>

                                                <td class="product-subtotal">
                                                    <?php if ($product->getDiscountedPrice() !== null): ?>
                                                        <span class="amount"><?= $product->getDiscountedPrice() * $_SESSION['cartContents'][$id]['qty']; ?> лв.</span>
                                                    <?php else: ?>
                                                        <span class="amount"><?= $product->getPrice() * $_SESSION['cartContents'][$id]['qty']; ?> лв.</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (isset($_SESSION['user_id'])): ?>
                                        <tr>
                                            <td class="actions" colspan="6">
                                                <input type="submit" value="Продължи" name="proceed" class="checkout-button button alt wc-forward" >
                                            </td>
                                        </tr>
                                            <?php endif; ?>
                                        <?php else: ?>
                                        <td class="product-quantity" colspan="6">
                                            <div class="quantity buttons_added">Количката ви е празна!</div>
                                        </td>
                                         <?php endif; ?>
                                    </tbody>
                                </table>
                            </form>

                            <?php if (!isset($_SESSION['user_id'])): ?>
                            <div class="woocommerce-info">Моля влезте в системата, за да можете да продължите напред! <a class="showlogin" data-toggle="collapse" href="#login-form-wrap" aria-expanded="false" aria-controls="login-form-wrap">Влезте от тук!</a>
                            </div>

                            <form id="login-form-wrap" class="login collapse" method="post" action="login.php">

                                <p class="form-row form-row-first">
                                    <label for="username">E-mail <span class="required">*</span>
                                    </label>
                                    <input type="text" id="username" name="email" class="input-text">
                                </p>
                                <p class="form-row form-row-last">
                                    <label for="password">Парола <span class="required">*</span>
                                    </label>
                                    <input type="password" id="password" name="password" class="input-text">
                                </p>
                                <div class="clear"></div>


                                <p class="form-row">
                                    <input type="submit" value="Вход" name="login" class="button">
                                </p>

                                <p> Нямате регистрация? <a href="register.php">Регистрирайте се от тук.</a></p>

                            </form>
                            <?php endif; ?>

                            <div class="cart-collaterals">
                                <div class="cart_totals ">
                                    <h2>Информация за количката</h2>
                                    <table cellspacing="0">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th>Цена</th>
                                                <td><span class="amount"><?= ($data) ? $data->getTotalCartPrice() : 0;?> лв.</span></td>
                                            </tr>

                                            <tr class="shipping">
                                                <th>Цена за доставка</th>
                                                <td>Безплатна доставка</td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Крайна цена</th>
                                                <td><strong><span class="amount"><?= ($data) ? $data->getTotalCartPrice() : 0 ?> лв.</span></strong> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>

<?php
include_once "footer_frontend.php";
?>
