<?php
include_once "header_frontend.php";
?>
    
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Администрация</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <?php if (isset($_SESSION['msg'])): ?>
                    <div class="ivo-success-msg">
                        <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
                    </div>
                <?php endif; ?>
                <div class="col-md-4  ivo-profile-sidebar">
                    <ul class="ivo-profile-nav">
                        <li>АДМИНИСТРАТИВНО МЕНЮ</li>
                        <li class="ivo-selected-li"><a class="ivo-selected" href="admin_add_product.php">Добави продукт</a></li>
                        <li class="ivo-selected-li"><a class="ivo-selected" href="admin_add_options.php">CMS</a></li>
                    </ul>
                    <br>
                    <ul class="ivo-profile-nav">
                        <li>ПОТРЕБИТЕЛСКО МЕНЮ</li>
                        <li><a href="user_profile.php">Моят профил</a></li>
                        <li><a href="user_profile.php?orders=1">Моите поръчки</a></li>
                    </ul>
                </div>
                
                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <div id="ivo-options-container">

                                <div id="customer_details" class="col2-set">
                                    <div class="col-1">
                                        <div class="woocommerce-billing-fields">
                                            <h3>Добавяне/Редактиране на</h3>
                                            <br>
                                            <h3> марки, категории, подкатегории, цветове или размери</h3>

                                            <?php if (isset($errorMessage)): ?>
                                                <div class="ivo-has-error">
                                                    <?= $errorMessage ?>
                                                </div>
                                            <?php endif; ?>

                                            <form method="post">
                                            <p id="add_product_brand_field" class="form-row form-row-wide address-field update_totals_on_change validate-required woocommerce-validated">
                                                <label class="" for="add_product_brand_select">Марка <abbr title="required" class="required">*</abbr>
                                                </label>
                                                <select class="select_brand" id="add_product_brand_select" name="brand">
                                                    <?php foreach ($brands as $brand): ?>
                                                        <option value="<?= $brand->getId() ?>"><?php echo $brand->getBrand() ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </p>
<!--                                                <input type="submit" class="button alt" value="запази" name="optnSubmit">-->
                                            </form>

                                            <form method="post">
                                                <p id="add_product_colour_field" class="form-row form-row-wide address-field update_totals_on_change validate-required woocommerce-validated">
                                                    <label class="" for="add_product_colour_select">Цвят <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <select class="select_colour" id="add_product_colour_select" name="colour">
                                                        <?php foreach ($colours as $colour): ?>
                                                            <option value="<?= $colour->getId() ?>"><?php echo $colour->getColour() ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </p>
                                                <!--                                            <input type="submit" class="button alt" value="запази" name="optnSubmit">-->
                                            </form>

                                            <form method="post">
                                            <p id="add_product_category_field" class="form-row form-row-wide address-field update_totals_on_change validate-required woocommerce-validated">
                                                <label class="" for="add_product_category_select">Категория <abbr title="required" class="required">*</abbr>
                                                </label>
                                                <select class="select_category" id="add_product_category_select" name="category">
                                                    <option value="-1">-- Избери категория --</option>
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?= $category->getId() ?>"><?php echo $category->getCategory() ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </p>
<!--                                            <input type="submit" class="button alt" value="запази" name="optnSubmit">-->
                                            </form>

                                            <form method="post">
                                            <p id="add_product_subCategory_field" class="form-row form-row-wide address-field update_totals_on_change validate-required woocommerce-validated">
                                                <label class="" for="add_product_subCategory_select">Подкатегория <abbr title="required" class="required">*</abbr>
                                                </label>
                                                <select class="select_brand" id="add_product_subCategory_select" name="subCategory">
                                                    <?php foreach ($subCategories as $sCategory): ?>
                                                        <option data-category-id="<?= $sCategory->getMainCategory() ?>" value="<?= $sCategory->getId() ?>"><?php echo $sCategory->getSubCategory() ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </p>
<!--                                            <input type="submit" class="button alt" value="запази" name="optnSubmit">-->
                                            </form>

                                            <form method="post">
                                            <p id="add_product_size_field" class="form-row form-row-wide address-field update_totals_on_change validate-required woocommerce-validated">
                                                <label class="" for="add_product_size_select">Размер <abbr title="required" class="required">*</abbr>
                                                </label>
                                                <select class="select_size add_product_size_select" name="size[]">
                                                    <?php foreach ($sizes as $size): ?>
                                                        <option data-category-id="<?= $size->getMainCategory()?>" value="<?= $size->getId() ?>"><?php echo $size->getSize() ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </p>
<!--                                            <input type="submit" class="button alt" value="запази" name="optnSubmit">-->
                                            </form>

                                            <div class="clear"></div>

<!--                                            <div class="form-row place-order">-->
<!---->
<!--                                                <input type="submit" value="Добави" id="add_option" name="add" class="button alt">-->
<!--                                            </div>-->
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
    </div>


<?php
include_once "footer_frontend.php";
?>

