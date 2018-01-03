<?php
include_once "header_frontend.php";
?>
    <div class="container ivo-container">
        <div class="row">
                <form method="post" id="ivo-register-form">
                    <div id="customer_details" class="">
                        <h3>Регистрация</h3>
                        <div class="col-lg-12">
                            <?php if (isset($errorMessage)): ?>
                                <div class="ivo-has-error">
                                    <?= $errorMessage ?>
                                </div>
                            <?php endif; ?>
                            <p>
                                <label class="" for="reg-email">E-mail <abbr title="required" class="required">*</abbr>
                                </label>
                                <input type="text" id="reg-email" name="email">
                            </p>
                            <p>
                                <label class="" for="reg-pass">Парола <abbr title="required" class="required">*</abbr>
                                </label>
                                <input type="password" id="reg-pass" name="password">
                            </p>
                            <p>
                                <label class="" for="reg-confirmpass">Парола (повторно) <abbr title="required"
                                                                                              class="required">*</abbr>
                                </label>
                                <input type="password" id="reg-confirmpass" name="confirmPassword">
                            </p>
                            <p>
                                <label class="" for="reg-firstname">Първо име<abbr title="required"
                                                                                   class="required">*</abbr>
                                </label>
                                <input type="text" id="reg-firstname" name="firstName">
                            </p>
                            <p>
                                <label class="" for="reg-lastname">Фамилно име<abbr title="required"
                                                                                    class="required">*</abbr>
                                </label>
                                <input type="text" id="reg-lastname" name="lastName">
                            </p>
                            <p>
                                <label class="" for="reg-birthdate">Дата на раждане<abbr title="required"
                                                                                         class="required">*</abbr>
                                </label>
                                <input type="text" id="reg-birthdate" name="birthDate">
                            </p>
                            <p>
                                <label class="" for="reg-phone">Телефонен номер<abbr title="required"
                                                                                     class="required">*</abbr>
                                </label>
                                <input type="text" id="reg-phone" name="phone">
                            </p>
                        </div>
<!--                        <div class="col-lg-6">-->

<!--                            <p>-->
<!--                                <label class="" for="reg-city">Град<abbr title="required"-->
<!--                                                                         class="required">*</abbr>-->
<!--                                </label>-->
<!--                                <input type="text" id="reg-city" name="city">-->
<!--                            </p>-->
<!--                            <p>-->
<!--                                <label class="" for="reg-address">Адрес<abbr title="required"-->
<!--                                                                             class="required">*</abbr>-->
<!--                                </label>-->
<!--                                <input type="text" id="reg-address" name="address">-->
<!--                            </p>-->
<!--                        </div>-->
                        <div class="col-lg-12 ivo-submit-div">
                            <input type="submit" class="" value="Регистрация" name="register">
                        </div>

                    </div>
                </form>
        </div>
        <div class="ivo-showlogin">
            Вече си регистриран? <a href="login.php">Влез в системата от тук.</a>
        </div>
    </div>

<?php
include_once "footer_frontend.php";
