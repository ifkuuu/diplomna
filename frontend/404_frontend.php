<?php
include_once "header_frontend.php"
?>

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <?php if (!isset($error)): ?>
                            <h2>Грешка</h2>
                            <h2>Търсената от вас страница не може да бъде намерена <br> или нямате достъп до нея</h2>
                        <?php endif; ?>

                        <?php if (isset($error)): ?>
                                <h2>За да видите тази страница трябва да влезете в системата, моля влезте от <a style="color: #2b2b2b" href="login.php">тук</a></h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php
include_once "footer_frontend.php";