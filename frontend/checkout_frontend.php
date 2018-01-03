<?php
include_once "header_frontend.php";
/** @var $data \Data\Products\CartViewData */
/** @var $cities \Data\City[] */
?>

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">

                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="woocommerce">

<!--                            <form id="coupon-collapse-wrap" method="post" class="checkout_coupon collapse">-->
<!---->
<!--                                <p class="form-row form-row-first">-->
<!--                                    <input type="text" value="" id="coupon_code" placeholder="Coupon code" class="input-text" name="coupon_code">-->
<!--                                </p>-->
<!---->
<!--                                <p class="form-row form-row-last">-->
<!--                                    <input type="submit" value="Apply Coupon" name="apply_coupon" class="button">-->
<!--                                </p>-->
<!---->
<!--                                <div class="clear"></div>-->
<!--                            </form>-->

                            <form enctype="multipart/form-data" id="ivo-checkout-form" action="#" class="checkout" method="post" name="checkout">

                                <div id="customer_details" class="col2-set">
                                    <div class="col-1">
                                        <div class="woocommerce-billing-fields">
                                            <h3>Адрес за доставка</h3>
                                            <?php if (isset($errorMessage)): ?>
                                                <div class="ivo-has-error">
                                                    <?= $errorMessage ?>
                                                </div>
                                            <?php endif; ?>
                                            <p id="billing_city_field" class="form-row form-row-wide address-field validate-required" data-o_class="form-row form-row-wide address-field validate-required">
                                                <label class="" for="billing_city">Град / Село <abbr title="required" class="required">*</abbr>
                                                </label>
                                                <select id="billing_city" name="city" class="chosen-select">
                                                    <option disabled selected> - Избери - </option>
                                                    <?php foreach ($cities as $city): ?>
                                                        <option value="<?= $city->getId() ?>"><?= $city->getName() ?> (п.к. <?= $city->getPostCode() ?> )</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </p>

                                            <p id="billing_address_1_field" class="form-row form-row-wide address-field validate-required">
                                                <label class="" for="billing_address">Адрес <abbr title="required" class="required">*</abbr>
                                                </label>
                                                <input type="text" value="" placeholder="ул. Видима №9, ет.8, ап.24" id="billing_address" name="billing_address" class="input-text ">
                                            </p>

                                            <p id="order_comments_field" class="form-row notes">
                                                <label class="" for="order_comments">Допълнителна бележка</label>
                                                <textarea cols="5" rows="2" placeholder="Допълнителна информация/желание относно поръчката." id="order_comments" class="input-text " name="order_comments"></textarea>
                                            </p>
                                            <div class="clear"></div>
                                        </div>
                                    </div>


                                        </div>

                                    </div>

                                </div>

                                <h3 id="order_review_heading">Вашата поръчка</h3>

                                <div id="order_review" style="position: relative;">
                                    <table class="shop_table">
                                        <thead>
                                        <tr>
                                            <th class="product-name">Продукт</th>
                                            <th class="product-total">Цена</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if ($data !== false): ?>
                                            <?php foreach ($data->getCartProducts() as $id => $product): ?>
                                                <tr class="cart_item">
                                                    <td class="product-name">
                                                        <?= $product->getName() ?><strong class="product-quantity"> × <?= $_SESSION['cartContents'][$id]['qty'] ?></strong>
                                                    </td>
                                                    <td class="product-total">
                                                        <?php if ($product->getDiscountedPrice() !== null): ?>
                                                            <span class="amount"><?= $product->getDiscountedPrice() * $_SESSION['cartContents'][$id]['qty']; ?> лв.</span>
                                                        <?php else: ?>
                                                            <span class="amount"><?= $product->getPrice() * $_SESSION['cartContents'][$id]['qty']; ?> лв.</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <input type="hidden" value="<?= $_SESSION['cartContents'][$id]['qty']; ?>" name="productsQty[<?= $id ?>]">
                                                <?php if ($product->getDiscountedPrice() !== null): ?>
                                                    <input type="hidden" value="<?= $product->getDiscountedPrice() ?>" name="productsPrice[<?= $id ?>]">
                                                <?php else: ?>
                                                    <input type="hidden" value="<?= $product->getPrice() ?>" name="productsPrice[<?= $id ?>]">
                                                <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        <input type="hidden" value="<?= ($data) ? $data->getTotalCartPrice() : 0; ?>" name="orderCost">
                                        </tbody>
                                        <tfoot>

                                        <tr class="cart-subtotal">
                                            <th>Цена</th>
                                            <td><span class="amount"><?= ($data) ? $data->getTotalCartPrice() : 0;?> лв.</span>
                                            </td>
                                        </tr>

                                        <tr class="shipping">
                                            <th>Цена за доставка</th>
                                            <td>

                                                Безплатна доставка
                                                <input type="hidden" class="shipping_method" value="free_shipping" id="shipping_method_0" data-index="0" name="shipping_method[0]">
                                            </td>
                                        </tr>


                                        <tr class="order-total">
                                            <th>Крайна цена</th>
                                            <td><strong><span class="amount"><?= ($data) ? $data->getTotalCartPrice() : 0;?> лв.</span></strong> </td>
                                        </tr>
                                        </tfoot>
                                    </table>


                                    <div id="payment">
                                        <ul class="payment_methods methods">
                                            <li class="payment_method_bacs">
                                                <input type="radio" data-order_button_text="" checked="checked" value="Виртуални пари" name="payment_method" class="input-radio" id="payment_method_bacs">
                                                <label for="payment_method_bacs">Виртуални пари</label>
                                                <div class="payment_box payment_method_bacs">
                                                    <p>Плащане разработено с тестови цели. Всеки потребител започва с фиксирани  виртуални "пари".</p>
                                                </div>
                                            </li>
                                            <li class="payment_method_bacs">
                                                <input type="radio" data-order_button_text="" value="Наложен платеж" name="payment_method" class="input-radio" id="payment_method_bacs">
                                                <label for="payment_method_bacs">Наложен платеж</label>
                                                <div class="payment_box payment_method_bacs">
                                                    <p>Плащане в кеш на куриер.</p>
                                                </div>
                                            </li>
<!--                                            <li class="payment_method_bacs">-->
<!--                                                <input type="radio" data-order_button_text="" checked="checked" value="bacs" name="payment_method" class="input-radio" id="payment_method_bacs">-->
<!--                                                <label for="payment_method_bacs">Direct Bank Transfer </label>-->
<!--                                                <div class="payment_box payment_method_bacs">-->
<!--                                                    <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>-->
<!--                                                </div>-->
<!--                                            </li>-->
<!--                                            <li class="payment_method_cheque">-->
<!--                                                <input type="radio" data-order_button_text="" value="cheque" name="payment_method" class="input-radio" id="payment_method_cheque">-->
<!--                                                <label for="payment_method_cheque">Cheque Payment </label>-->
<!--                                                <div style="display:none;" class="payment_box payment_method_cheque">-->
<!--                                                    <p>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>-->
<!--                                                </div>-->
<!--                                            </li>-->
<!--                                            <li class="payment_method_paypal">-->
<!--                                                <input type="radio" data-order_button_text="Proceed to PayPal" value="paypal" name="payment_method" class="input-radio" id="payment_method_paypal">-->
<!--                                                <label for="payment_method_paypal">PayPal <img alt="PayPal Acceptance Mark" src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png"><a title="What is PayPal?" onclick="javascript:window.open('https://www.paypal.com/gb/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" class="about_paypal" href="https://www.paypal.com/gb/webapps/mpp/paypal-popup">What is PayPal?</a>-->
<!--                                                </label>-->
<!--                                                <div style="display:none;" class="payment_box payment_method_paypal">-->
<!--                                                    <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>-->
<!--                                                </div>-->
<!--                                            </li>-->
                                        </ul>

                                        <div class="form-row place-order">

                                            <input type="submit" data-value="Place order" value="Поръчай" id="place_order" name="place_order" class="button alt">


                                        </div>

                                        <div class="clear"></div>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once "footer_frontend.php";
