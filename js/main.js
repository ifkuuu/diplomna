jQuery(document).ready(function($){
    
    // jQuery sticky Menu
    
	$(".mainmenu-area").sticky({topSpacing:0});
    
    
    $('.product-carousel').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:5,
            }
        }
    });  
    
    $('.related-products-carousel').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:2,
            },
            1000:{
                items:2,
            },
            1200:{
                items:3,
            }
        }
    });  
    
    $('.brand-list').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:4,
            }
        }
    });    
    
    
    // Bootstrap Mobile Menu fix
    $(".navbar-nav li a").click(function(){
        $(".navbar-collapse").removeClass('in');
    });    
    
    // jQuery Scroll effect
    $('.navbar-nav li a, .scroll-to-up').bind('click', function(event) {
        var $anchor = $(this);
        var headerH = $('.header-area').outerHeight();
        $('html, body').stop().animate({
            scrollTop : $($anchor.attr('href')).offset().top - headerH + "px"
        }, 1200, 'easeInOutExpo');

        event.preventDefault();
    });    
    
    // Bootstrap ScrollPSY
    $('body').scrollspy({ 
        target: '.navbar-collapse',
        offset: 95
    });

    /* ============================================================================================================== */

    // Ivo - jQuery UI DatePicker functionality
    $("#reg-birthdate").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
    });

    /* ============================================================================================================== */

    // Ivo - add ivo-selected class to user profile ul
    $(".ivo-profile-nav li a").on("click", function() {
        $(".ivo-profile-nav li").removeClass("ivo-selected-li");
        $(".ivo-profile-nav li a").removeClass("ivo-selected");
        $(this).addClass("ivo-selected");
        $(this).parent('li').addClass("ivo-selected-li");
    });

    /* ============================================================================================================== */

    // Ivo - add active class to header nav
    let ivoUrl = window.location.pathname;
    // Get just the file name (ex. search.php) and find an <a> with that href and add class 'active' to it.
    ivoUrl = ivoUrl.split('/');
    ivoUrl = ivoUrl.slice(-1).pop();
    $(".nav li").removeClass("active");
    $('.nav li a[href="'+ivoUrl+'"]').parent('li').addClass("active");

    /* ============================================================================================================== */

    $('#add_product_subCategory_select').parent().hide();
    $('.add_product_size_select').prop('disabled', true);
    // Ivo - Limit select field options for subCategory based ot Category select field - used in admin_add_product.php
    $("#add_product_category_select").change(function() {
        // Remove the first option "-- Избери категория --".
        $(this).find('option[value="-1"]').remove();

        let sizesSelect = $('.add_product_size_select');
        let subCategorySelect = $('#add_product_subCategory_select');
        // Show subcategories select field.
        subCategorySelect.parent().show();
        sizesSelect.prop('disabled', false);

        if ($(this).data('options') === undefined) {
            /* Taking an array of all options-2 and kind of embedding it on the select1 */
            $(this).data('options', subCategorySelect.find('option').clone());
            $(this).data('sizesOptions', sizesSelect.find('option').clone());
        }

        let id = $(this).val();
        let options = $(this).data('options').filter('[data-category-id=' + id + ']');
        let sizesOptions = $(this).data('sizesOptions').filter('[data-category-id=' + id + ']');
        subCategorySelect.html(options);
        sizesSelect.html(sizesOptions);
    });

    /* ============================================================================================================== */

    // Adds more fields for sizes and pictures in admin_add_product.php
    $('#btn-add-more-sizes').on("click", function () {
        sizesDiv = $(".ivo-size-and-quantity:first");
        newSizesDiv = sizesDiv.clone();
        newSizesDiv.find(".add_product_quantity_input").val("");
        newSizesDiv.insertBefore($(this));
    });

    $('#btn-add-more-pictures').on("click", function () {
        pictureDiv = $(".ivo-pictures:first");
        newPictureDiv = pictureDiv.clone();
        newPictureDiv.find(".add_product_image_input").val("");
        newPictureDiv.insertBefore($(this));
    });

    /* ============================================================================================================== */
    // JQuery Validator

    // Override default validator plugin messages
    jQuery.extend(jQuery.validator.messages, {
        required: "Това поле е задължително!",
        lettersonly: "Моля въведете само букви!",
        date: "Моля въведете правилна дата (например 12/31/2017)",
        email: "Моля въведете валиден имейл!",
        number: "Моля въведете число!"
    });

    // Set Defaults (error class)
    $.validator.setDefaults({
        highlight: function (element) {
            $(element).addClass('ivo-has-error');
            $(element).closest('p').addClass('ivo-has-error');
        },
        unhighlight: function (element) {
            $(element).removeClass('ivo-has-error');
            $(element).closest('p').removeClass('ivo-has-error');
        }
    });

    // Validate Add Product Form
    // na rules i na messages se podavat NAME atributite na poletata
    $('#ivo-add-product-form').validate({
        rules: {
            name: {
                required: true
            },
            price: {
                required: true,
                number: true
            },
            category: {
                required: true
            },
            subCategory: {
                required: true
            },
            brand: {
                required: true
            },
            gender: {
                required: true
            },
            colour: {
                required: true
            },
            size: {
                required: true
            }
        },
    });

    // Validate Register Form
    $('#ivo-register-form').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                pattern: /^[\w]{3,20}$/
            },
            confirmPassword: {
                required: true,
                equalTo: "#reg-pass"
            },
            firstName: {
                required: true,
                lettersonly: true
            },
            lastName: {
                required: true,
                lettersonly: true
            },
            birthDate: {
                required: true,
                date: true
            },
            phone: {
                required: true,
                pattern: /^[0-9-\/\\ 	]{6,15}$/
            }
        },
        messages: {
            email: {
                email: "Моля въведете валиден имейл!"
            },
            password: {
                pattern: "Позволени са само букви, числа и долни черти! Между 3 и 20 символа."
            },
            confirmPassword: {
                equalTo: "Моля въведете същата парола, като в първото поле за парола!"
            },
            phone: {
                pattern: "Позволени са цифри, \\, /, - и празни разстояния. Между 6 и 15 символа."
            }
        }
    });

    // Validate Checkout Form
    $('#ivo-checkout-form').validate({
        rules: {
            city: {
                required: true,
            },
            billing_address: {
                required: true
            }
        }
    });

    // Ivo - Custom function for retrieving query string parameters. (found it in stackoverflow).
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    // Ivo - Ajax for loading available sizes based on colour selected.
    let sizesSelect = $('#product-sizes');
    sizesSelect.prop('disabled', true);
    $('#product-colours').on("change", function () {
        productId = getParameterByName('product');
        $(this).find('option:first').hide();
        $.ajax({
            url: 'ajax.php',
            data: "colour=" + $(this).val() + "&product=" + productId,
            success: function(data) {
                data = JSON.parse(data);
                let str = '';
                for (value of data) {
                    str += 'option[value='+value['id']+'],';
                }
                str = str.replace(/,\s*$/, "");
                sizesSelect.find('option').hide();
                sizesSelect.find(str).show();
                sizesSelect.find('option:first').text('- Избери размер -');
            },
            complete: function () {
                // Added a little delay, cause i think it helps with the bugged javascript loading.. not sure though.
                setTimeout(function () {
                    sizesSelect.prop('disabled', false);
                }, 500);
            },
        });
    });

    // Ivo - First ajax is for getting the correct variant ID, The second is for reloading the page's body content.
    sizesSelect.on("change", function () {
        let coloursSelect = $('#product-colours');
        variantId = getParameterByName('product');
        $.ajax({
            async: true,
            url: 'ajax.php',
            data:  {
                colour: coloursSelect.val(),
                size: $(this).val(),
                product: variantId
            },
            success: function (newId) {
                $.ajax({
                    async: true,
                    url: 'single_product.php',
                    dataType: 'html',
                    data: {
                        product: newId
                    },
                    success: function (content) {
                        content = content.substring(content.indexOf("<body>"),content.indexOf("</body>")+7);
                        // content = content.substring(content.indexOf("<body>")+6,content.indexOf("</body>"));
                       $("body").html(content);
                    },
                });
            },
            // Set the url's product id to the one loaded with Ajax.
            complete: function (response) {
                let url = window.location.pathname;
                url += "?product=" + response.responseText;
                window.history.pushState('page2', 'Title', url);
            },
        });
    });

    /* ============================================================================================================== */

    // Adds Chosen library to this class.
    $(".chosen-select").chosen({disable_search_threshold: 10});

    /* ============================================================================================================== */

    // Ivo - wrote this to be able to change the main image, but decided to use fancybox library instead.
    // $("div#product-images div.product-gallery a").on('click', function(e) {
    //     e.preventDefault();
    //
    //     $('#ivo-product-main-img').attr('src', $(this).attr('href'));
    // });

    /* ============================================================================================================== */

});
