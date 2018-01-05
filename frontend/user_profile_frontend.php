<?php
include_once "header_frontend.php"
/** @var \Data\Users\User $user */
/** @var \Data\Orders\Order[] $orders */
?>
    
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Профил</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
    
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 ivo-profile-sidebar">
                <?php if ($user->isAdmin()): ?>
                    <ul class="ivo-profile-nav">
                        <li>АДМИНИСТРАТИВНО МЕНЮ</li>
                        <li><a href="admin_add_product.php">Добави продукт</a></li>
                    </ul>
                    <br>
                <?php endif; ?>
                    <ul class="ivo-profile-nav">
                        <li>ПОТРЕБИТЕЛСКО МЕНЮ</li>
                        <li  class="ivo-selected-li"><a class="ivo-selected" href="user_profile.php">Моят профил</a></li>
                        <li><a href="user_profile.php?orders=1">Моите поръчки</a></li>
                    </ul>
                </div>
                
                <div class="col-md-8">
                    <?php if (!isset($orders)): ?>
                    <div>
                        <h3>Здравей, <?= $user->getFirstName() ?></h3>
                        <p>Твоята потребителска роля е: <?= $user->getRole() ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="ivo-orders-container">
                                <ul class="ivo-order-fieldset">
                                    <li> <a>Поръчка № <?= $order->getId() ?></a></li>
                                    <li><table class="shop_table">
                                        <thead>
                                        <tr>
                                            <th class="product-name">Продукт</th>
                                            <th class="product-total">Цена</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                    <?php foreach ($order->getProducts() as $product): ?>
                                        <tr class="cart_item">
                                            <td class="product-name">
                                                <?= $product->getName() ?><strong class="product-quantity"></strong>
                                            </td>
                                            <td class="product-total">
                                                <span class="amount"><?= $product->getPrice() ?> лв.</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>

                                        <tr class="cart-subtotal">
                                            <th>Цена</th>
                                            <td><span class="amount"><?= $order->getOrderCost() ?> лв.</span>
                                            </td>
                                        </tr>

                                        <tr class="shipping">
                                            <th>Цена за доставка</th>
                                            <td>

                                                Безплатна доставка
                                                <input class="shipping_method" value="free_shipping" id="shipping_method_0" data-index="0" name="shipping_method[0]" type="hidden">
                                            </td>
                                        </tr>


                                        <tr class="order-total">
                                            <th>Крайна цена</th>
                                            <td><strong><span class="amount"><?= $order->getOrderCost() ?> лв.</span></strong> </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    </li>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php
include_once "footer_frontend.php";
