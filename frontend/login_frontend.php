<?php
include_once "header_frontend.php";
?>
    <div class="container ivo-container">
        <div class="row">
            <div id="customer_details" class="">
                <h3>Влизане в сайта</h3>
                <div class="col-lg-12">
                    <form method="post">
                        <p>
                            <label for="log-email">E-mail</label>
                            <input type="text" id="log-email" name="email">
                        </p>
                        <p>
                            <label for="log-pass">Парола</label>
                            <input type="text" id="log-pass" name="password">
                        </p>
                        <div class="ivo-submit-div">
                            <input type="submit" name="login" value="Вход">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="ivo-showlogin">
            Нямаш регистрация? <a href="register.php">Регистрирай се от тук.</a>
        </div>
    </div>

<?php
include_once "footer_frontend.php";
