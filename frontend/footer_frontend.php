<?php
$optionsService = new \Service\OptionsService($db);
/** @var \Data\Category[] $categories */
$categories = $optionsService->getCategories();
/** @var \Data\Gender[] $genders */
$genders = $optionsService->getGenders();
?>
<div class="footer-top-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="footer-about-us">
                    <h2>Ivo's<span> Abyss</span></h2>
                    <p>Добре дошли! <br>
                        Този сайт е първият ми проект на php и въобще в програмирането.
                        Идеята ми е да го ползвам като дипломна работа.
                    </p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/ifkuuu" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="https://www.youtube.com/user/ifkuuu" target="_blank"><i class="fa fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">Потребителска навигация </h2>
                    <ul>
                        <li><a href="user_profile.php">Моят профил</a></li>
                        <li><a href="user_profile.php?orders=1">История на поръчките</a></li>
                        <li><a href="index.php">Начална страница</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">Категории</h2>
                    <ul>
                        <?php foreach ($genders as $gender): ?>
                            <li><a href="all_products.php?gender=<?= $gender->getId() ?>"><?= $gender->getGender() ?></a>
                            <ul>
                            <?php foreach ($categories as $category): ?>
                                <li><a href="all_products.php?gender=<?= $gender->getId() . '&cat=' . $category->getId() ?>"><?= $category->getCategory() ?></a></li>
                            <?php endforeach; ?>
                            </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!--            <div class="col-md-3 col-sm-6">
                            <div class="footer-newsletter">
                                <h2 class="footer-wid-title">Newsletter</h2>
                                <p>Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!</p>
                                <div class="newsletter-form">
                                    <input type="email" placeholder="Type your email">
                                    <input type="submit" value="Subscribe">
                                </div>
                            </div>
                        </div>-->
        </div>
    </div>
</div>
<div class="footer-bottom-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="copyright">
                    <!-- <p>&copy; 2015 eElectronics. All Rights Reserved. Coded with <i class="fa fa-heart"></i> by <a href="http://wpexpand.com" target="_blank">WP Expand</a></p>-->
                    <p> Създаден с <!--огромно желание, интерес и--> <i class="fa fa-heart"></i> от <a href="https://www.facebook.com/ifkuuu" target="_blank">Ивелин Енчев</a></p>
                </div>
            </div>

<!--            <div class="col-md-4">
                <div class="footer-card-icon">
                    <i class="fa fa-cc-discover"></i>
                    <i class="fa fa-cc-mastercard"></i>
                    <i class="fa fa-cc-paypal"></i>
                    <i class="fa fa-cc-visa"></i>
                </div>
            </div>-->
        </div>
    </div>
</div>

<!-- Latest jQuery form server -->
<script src="https://code.jquery.com/jquery.min.js"></script>

<!-- Bootstrap JS form CDN -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!-- jQuery sticky menu -->
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.sticky.js"></script>

<!-- jQuery easing -->
<script src="js/jquery.easing.1.3.min.js"></script>

<!-- jQuery UI -->
<script src="js/jquery-ui.js"></script>

<!-- jQuery Validate Plugin and Additional methods (such as for regex pattern) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>

<!-- jQuery Fancy box library -->
<script src="js/jquery.fancybox.min.js"></script>

<!-- Chosen library -->
<script src="js/chosen.jquery.min.js"></script>

<!-- Main Script -->
<script src="js/main.js"></script>
</body>
</html>
