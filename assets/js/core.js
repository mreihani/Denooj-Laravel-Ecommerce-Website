let _token = $('meta[name="csrf-token"]').attr('content');
let loader = $('.screen-loader');
let cartTotal = $('.cartTotal');
let cartTotalQuantity = $('#cartTotalQuantity');
let cartQuantity = $('.cartCount');

const Toast = Swal.mixin({
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

function number_3_3(num, sep) {
    let number = typeof num === "number" ? num.toString() : num,
        separator = typeof sep === "undefined" ? ',' : sep;
    return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + separator);
}

// enable bootstrap tooltip everywhere
let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})


// header scroll behavior
let header = $('#header-container');
let lastScrollTop = 0;
$(document).on('scroll',function (event){
    let scrollTop = $(this).scrollTop();
    if (scrollTop > lastScrollTop && scrollTop >= 300){
        header.addClass('minimized');
    } else {
        header.removeClass('minimized');
    }
    lastScrollTop = scrollTop;
});

// menu item toggle
$(document).on('click','.menu-item-toggle',function (){
    let toggle = $(this);
    let submenu = toggle.next('.submenu');
    if(submenu.hasClass('open')){
        submenu.removeClass('open');
        submenu.hide();
        toggle.html("<i class='icon-plus'></i>");
    }else{
        submenu.addClass('open');
        submenu.slideDown('fast');
        toggle.html("<i class='icon-minus'></i>");
    }

});

// menu burger button
$(document).on('click','#open-menu',function (){
    $('.menu-backdrop').fadeIn();
    $('.menu-items').addClass('open');
});

// menu close functions
$(document).on('click','.menu-backdrop,#close-menu',function (){
    $('.menu-backdrop').hide();
    $('.menu-items').removeClass('open');
});

// mini cart open
$(document).on('click','.open-cart',function (){
    $('.mini-cart-backdrop').fadeIn();
    $('.mini-shopping-cart').addClass('open');
});

// mini cart close
$(document).on('click','.close-cart,.mini-cart-backdrop',function (){
    $('.mini-cart-backdrop').hide();
    $('.mini-shopping-cart').removeClass('open');
})

// quicklook button
$(document).on('click','.btn-quicklook',function (){
    let modal = new bootstrap.Modal(document.getElementById('quicklook-modal'), {
        keyboard: false
    })
    modal.show();
});


function bookmark(btn){
    let id = $(btn).attr('data-id');
    let data = new FormData();
    data.append('id', id);

    let modelName = 'product';
    if ($(btn).attr('data-model-name')){
        modelName = $(btn).attr('data-model-name');
    }

    $(btn).addClass('loading');

    $.ajax({
        method: 'POST',
        url: '/panel/favorites/'+modelName+'/toggle/',
        data: data,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': _token},
        error: function () {
            $(btn).removeClass('loading');
        }
    }).done(function (data) {
        if ($.trim(data['status']) === 'success') {
            let msg = '';
            if($.trim(data['bookmark']) === 'like'){
                $(btn).html('<i class="icon-heart text-danger font-20"></i>');
                msg = 'به لیست علاقه‌مندی‌ها اضافه شد';
                if (modelName === 'post'){
                    msg = 'به لیست نشان‌شده‌ها اضافه شد';
                }
            }else if($.trim(data['bookmark']) === 'unlike'){
                $(btn).html('<i class="icon-heart font-20"></i>');
                msg = 'به لیست علاقه‌مندی‌ها اضافه شد';
                if (modelName === 'post'){
                    msg = 'به لیست نشان‌شده‌ها اضافه شد';
                }
            }

            Toast.fire({
                icon: 'success',
                title: msg
            })

        }
    }).always(function () {
        $(btn).removeClass('loading');
    });
}

// remove item from favorites
$(document).on('click','.btn-favorite-remove',function () {
    let id = $(this).attr('data-id');
    let container = $(this).parents('.product-col');
    let btn = $(this);

    let modelName = 'product';
    if (btn.attr('data-model-name')){
        modelName = $(btn).attr('data-model-name');
    }

    Swal.fire({
        text: "این محصول از لیست علاقه مندی های شما حذف شود؟",
        icon: 'warning',
        showCancelButton: true,
        focusCancel: true,
        confirmButtonText: 'بله، حذف کن',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-secondary me-3',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling:false
    }).then(function (result) {
        if (result.value) {
            btn.addClass('loading');
            let data = new FormData();
            data.append('id', id);

            $.ajax({
                method: 'POST',
                url: '/panel/favorites/'+modelName+'/remove/',
                data: data,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': _token},
                error: function () {
                    btn.removeClass('loading');
                }
            }).done(function (data) {
                if ($.trim(data['status']) === 'success'){
                    container.slideUp();
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'مشکلی پیش آمد!'
                    })
                }

            }).always(function () {
                btn.removeClass('loading');
            });
        }
    });

});


function addToCart(btn){
    let id = $(btn).attr('data-id');
    let data = new FormData();
    data.append('product_id', id);

    $(btn).addClass('loading');

    $.ajax({
        method: 'POST',
        url: '/cart/add/',
        data: data,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': _token},
        error: function () {
            $(btn).removeClass('loading');
        }
    }).done(function (data) {
        if ($.trim(data['status']) === 'low_quantity') {
            Toast.fire({
                icon: 'error',
                title: 'موجودی محصول کافی نیست!'
            })
        }
        else if ($.trim(data['status']) === 'out_of_stock') {
            Toast.fire({
                icon: 'error',
                title: 'موجودی محصول کافی نیست!'
            })
        }else if ($.trim(data['status']) === 'success') {
            
            Swal.fire({
                title: "به سبد خریدتان اضافه شد",
                text: "محصول مورد نظر با موفقیت به سبد خرید شما اضافه شد برای رزرو محصول سفارش خود را نهایی کنید.",
                icon: 'success',
                showCancelButton: true,
                focusCancel: true,
                confirmButtonText: 'نهایی کردن سفارش',
                cancelButtonText: 'فهمیدم',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-outline-secondary'
                },
                buttonsStyling:false
            }).then(function (result) {
                if (result.value) {
                    window.location.replace('/cart');
                }else{
                    window.location.reload();
                }
            });

        }else{
            Toast.fire({
                icon: 'error',
                title: 'مشکلی پیش آمد، عملیات انجام نشد!'
            })

        }
    }).always(function () {
        $(btn).removeClass('loading');
    });
}

function quantityAdd(button) {

    let btnQuantityAdd = $(button);
    let cartItem = btnQuantityAdd.parents('.cart-page-item');
    let btnQuantityMinus = cartItem.find('.quantityMinus');
    let rowId = cartItem.attr('row-id');
    let quantity = cartItem.find('.quantity');
    let priceSum = cartItem.find('.priceSum');
    let cartItemTotalDiscount = cartItem.find('.cartItemTotalDiscount');

    btnQuantityMinus.removeClass('d-none');
    loader.fadeIn('fast');

    let data = new FormData();
    data.append('id', rowId);

    $.ajax({
        method: 'POST',
        url: '/cart/increase/',
        data: data,
        processData: false,
        contentType: false,
        dataType: "json",
        headers: {'X-CSRF-TOKEN': _token},
        error: function () {
            loader.fadeOut('fast');
        }
    }).done(function (data) {
        if ($.trim(data['status']) === 'success') {
            quantity.html($.trim(data['quantity']));
            priceSum.html(number_3_3($.trim(data['item_price_sum'])));
            cartTotal.html(number_3_3($.trim(data['cart_total'])));
            cartTotalQuantity.html($.trim(data['cart_total_quantity']));
            $('#cartTotalDiscount').html(number_3_3($.trim(data['cart_total_discount'])));
            cartItemTotalDiscount.html(number_3_3($.trim(data['item_total_discount'])));

            $('.total-weight').html(number_3_3($.trim(data['total_weight'])));

            $('.cartTotal').html(number_3_3($.trim(data['cart_total'])));

            $('.subTotal').html(number_3_3($.trim(data['price_to_pay'])));

            if ($.trim(data['is_max_quantity']) === '1') {
                btnQuantityAdd.addClass('d-none');
            }

            // this is for checkout page, when minicart is clicked
            let addressSelect = $('#address_id');
            if (addressSelect.find('option').length > 1){
                addressSelect.find('option').attr('selected', false);
                let defaultOpt = addressSelect.find('option:nth-child(2)');
                defaultOpt.attr('selected', true);

                calcShippingCost(defaultOpt.val(), 'initial');
            }

        } else if ($.trim(data['status']) === 'max_quantity') {
            Toast.fire({
                'icon': 'warning',
                'text': 'بیشترین تعداد انتخاب شده است.',
            });
        } else {
            Toast.fire({
                'icon': 'error',
                'text': 'مشکلی پیش آمد، عملیات انجام نشد!',
            });
        }
    }).always(function () {
        loader.fadeOut('fast');
    });
}

function quantityMinus(button) {

    let btnQuantityMinus = $(button);
    let cartItem = btnQuantityMinus.parents('.cart-page-item');
    let btnQuantityAdd = cartItem.find('.quantityAdd');
    let rowId = cartItem.attr('row-id');
    let quantity = cartItem.find('.quantity');
    let priceSum = cartItem.find('.priceSum');
    let cartItemTotalDiscount = cartItem.find('.cartItemTotalDiscount');

    btnQuantityAdd.removeClass('d-none');
    loader.fadeIn('fast');

    let data = new FormData();
    data.append('id', rowId);

    $.ajax({
        method: 'POST',
        url: '/cart/decrease/',
        data: data,
        processData: false,
        contentType: false,
        dataType: "json",
        headers: {'X-CSRF-TOKEN': _token},
        error: function () {
            loader.fadeOut('fast');
        }
    }).done(function (data) {

        if ($.trim(data['status']) === 'success') {
            quantity.html($.trim(data['quantity']));
            priceSum.html(number_3_3($.trim(data['item_price_sum'])));
            cartTotal.html(number_3_3($.trim(data['cart_total'])));
            cartTotalQuantity.html($.trim(data['cart_total_quantity']));
            $('#cartTotalDiscount').html(number_3_3($.trim(data['cart_total_discount'])));
            cartItemTotalDiscount.html(number_3_3($.trim(data['item_total_discount'])));

            if ($.trim(data['quantity']) === '1') {
                btnQuantityMinus.addClass('d-none');
            }

            $('.total-weight').html(number_3_3($.trim(data['total_weight'])));
            
            $('.cartTotal').html(number_3_3($.trim(data['cart_total'])));

            $('.subTotal').html(number_3_3($.trim(data['price_to_pay'])));
           
            // this is for checkout page, when minicart is clicked
            let addressSelect = $('#address_id');
            if (addressSelect.find('option').length > 1){
                addressSelect.find('option').attr('selected', false);
                let defaultOpt = addressSelect.find('option:nth-child(2)');
                defaultOpt.attr('selected', true);

                calcShippingCost(defaultOpt.val(), 'initial');
            }
            
        } else if ($.trim(data['status']) === 'min_quantity') {
            Toast.fire({
                'icon': 'warning',
                'text': 'حداقل تعداد انتخاب شده است.',
            });
        } else {
            Toast.fire({
                'icon': 'error',
                'text': 'مشکلی پیش آمد، عملیات انجام نشد!',
            });
        }
    }).always(function () {
        loader.fadeOut('fast');
    });
}

function deleteFromCart(button) {
    let rowId = $(button).attr('row-id');
    let container = $(button).parents('.cart-item');

    Swal.fire({
        text: "این محصول از سبد خرید حذف شود؟",
        icon: 'warning',
        showCancelButton: true,
        focusCancel: true,
        confirmButtonText: 'حذف کن',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-danger me-3',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling:false
    }).then(function (result) {
        if (result.value) {
            loader.fadeIn('fast');
            let data = new FormData();
            data.append('id', rowId);

            $.ajax({
                method: 'POST',
                url: '/cart/delete/',
                data: data,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': _token},
                error: function () {
                    loader.fadeOut('fast');
                }
            }).done(function (data) {
                if ($.trim(data['status']) === 'success') {
                    container.addClass('bg-danger');
                    container.remove();
                    cartTotal.html(number_3_3($.trim(data['cart_total'])));
                    cartTotalQuantity.html($.trim(data['cart_total_quantity']));
                    cartQuantity.html($.trim(data['cart_quantity']));
                    $('#cartTotalDiscount').html(number_3_3($.trim(data['cart_total_discount'])));

                    if ($.trim(data['cart_quantity']) === '0') {
                        $('#btnCartPage').remove();
                        $('#alertInfo').hide();
                        $('.alertEmpty').removeClass('d-none');
                    }

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'مشکلی پیش آمد، عملیات انجام نشد!'
                    })
                }


            }).always(function () {
                loader.fadeOut('fast');
            });
        }
    });

}

// mini cart item delete
$(document).on('click','.cart-menu-remove',function () {
    let rowId = $(this).attr('data-id');

    let container = $(this).parents('.h-product-item');
    Swal.fire({
        text: "این محصول از سبد خرید حذف شود؟",
        icon: 'warning',
        showCancelButton: true,
        focusCancel: true,
        confirmButtonText: 'حذف کن',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-danger me-3',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling:false
    }).then((result) => {
        if (result.value) {

            loader.fadeIn('fast');
            let data = new FormData();
            data.append('id',rowId);

            $.ajax({
                method: 'POST',
                url: '/cart/delete/',
                data: data,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': _token},
                error: function (e) {
                    console.log(e);
                    loader.fadeOut('fast');
                }
            }).done(function (data) {
                console.log(data);
                if ($.trim(data['status']) === 'success') {
                    container.addClass('bg-danger');
                    container.hide();
                    $('#mini_cart_total').html(number_3_3($.trim(data['cart_total'])));
                    $('#mini_cart_count').html($.trim(data['cart_quantity']));

                    if ($.trim(data['cart_quantity']) === '0'){
                        $('.alertEmpty').removeClass('d-none');
                    }

                } else{
                    Swal.fire({
                        'icon':'error',
                        'text':'مشکلی پیش آمد، محصول حذف نشد!',
                    });
                }

            }).always(function () {
                loader.fadeOut('fast');
            });
        }
    });
});

// share modal copy link button
$(document).on('click','#btnCopyLink',function (e){
    let btn = $(this);
    e.preventDefault();
    let copyText = document.getElementById("inputToCopy");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    btn.html('<i class="icon-check-circle me-2"></i><span>کپی شد</span>');

    setTimeout(function (){
        btn.html('<i class="icon-copy me-2"></i><span>کپی کردن لینک</span>');
    },2000);
});

// collapse box
$(document).ready(function(){
    // check content area dropdown
    let contentEl = $('.content-dropdown');
    let contentElHeight = contentEl.height();
    if (parseInt(contentElHeight) < 160){
        contentEl.removeClass('content-dropdown');
        contentEl.find('.content-dropdown-toggle').remove();
    }

    // content dropdown
    $(document).on('click','.content-dropdown-toggle',function (){
        let btn = $(this);
        let content = btn.parent('.content-dropdown');
        if (content.hasClass('open')){
            content.removeClass('open');
            btn.html('<span>مشاهده بیشتر</span><i class="icon-chevron-down ms-2"></i>');
        }else{
            content.addClass('open');
            btn.html('<span>مشاهده کمتر</span><i class="icon-chevron-up ms-2"></i>');
        }
    })
});


// get cities
let provinceSelect = $('#province');
let citySelect = $('#city');
provinceSelect.change(function () {
    let id = $(this).val();
    if(id !== ''){
        let data = new FormData();
        data.append('province_id',id);
        $.ajax({
            method: 'POST',
            url: '/panel/get-cities/',
            data: data,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': _token},
            error: function () {
            }
        }).done(function (data) {
            citySelect.empty();
            $(data).each(function (index,item) {
                citySelect.append($('<option>', {
                    value: item['id'],
                    text: item['name']
                }));
            });

        }).always(function () {

        });
    }else{
        citySelect.empty();
        if(citySelect.hasClass('all')){
            citySelect.append($('<option>', {
                value: '',
                text: 'استان را انتخاب کنید'
            }));
        }
    }
});


// apply coupon
$('#btnCouponApply').on('click', function () {
    let code = $('#couponCode');
    if (code.val().length > 0) {
        applyCoupon();
    }

    function applyCoupon() {
        let data = new FormData();
        data.append('code', code.val());

        loader.fadeIn('fast');

        $.ajax({
            method: 'POST',
            url: '/cart/coupon/apply/',
            data: data,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': _token},
            error: function (e) {
                console.log(e);
                loader.fadeOut('fast');
            }
        }).done(function (data) {
            console.log(data);
            if (data['status'] === 'error') {
                Swal.fire({
                    icon: 'error',
                    text: data['msg']
                });
                code.val('');
            } else if (data['status'] === 'success') {
                Swal.fire({
                    icon: 'success',
                    text: data['msg']
                }).then(function () {
                    window.location.reload();
                });
            }
        }).always(function () {
            loader.fadeOut('fast');
        });
    }

});

// remove coupon
$('.btn-coupon-remove').on('click', function () {
    let code = $(this).attr('data-code');
    let conditionName = $(this).attr('data-condition-name');
    let data = new FormData();
    data.append('condition_name', conditionName);
    data.append('code', code);

    loader.fadeIn('fast');

    $.ajax({
        method: 'POST',
        url: '/cart/coupon/remove/',
        data: data,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': _token},
        error: function (e) {
            console.log(e);
            loader.fadeOut('fast');
        }
    }).done(function (data) {
        if (data['status'] === 'error') {
            Swal.fire({
                icon: 'error',
                text: data['msg']
            });
        } else if (data['status'] === 'success') {
            Swal.fire({
                icon: 'success',
                text: data['msg']
            }).then(function () {
                window.location.reload();
            });
        }
    }).always(function () {
        loader.fadeOut('fast');
    });
});


// admin navigation menu toggle
$(document).on('click','.admin-nav-toggle',function (){
    $('.admin-nav-backdrop').fadeIn();
    $('.admin-navbar-items').addClass('open');
});
// admin navigation menu close functions
$(document).on('click','.admin-nav-backdrop',function (){
    $('.admin-nav-backdrop').hide();
    $('.admin-navbar-items').removeClass('open');
});
