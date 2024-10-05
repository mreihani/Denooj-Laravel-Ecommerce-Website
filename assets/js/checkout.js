// remove loading button on browser back button click
window.addEventListener('pageshow',function (){
    $("#btnSubmitPay").removeClass('loading');
})

$(document).on('click','#btnSubmitPay', function (e) {
    e.preventDefault();

    let addressSelect = $('select[name=address_id]');
    let btn = $(this);

    if (addressSelect.length && addressSelect.val() !== ''){

        // check zero amount
        let amount = parseInt($('#priceToPay').val());
        if (amount <= 0){
            Toast.fire({
                icon: "warning",
                text: "امکان پرداخت وجود ندارد مبلغ سفارش معتبر نیست."
            });
        }else{
            btn.addClass('loading');
            $('#checkoutForm').submit();
        }

    }else{
        Toast.fire({
            icon: "warning",
            text: "آدرس خود را مشخص کنید."
        });
        $(window).scrollTop(0);
    }
});


$(document).ready(function () {

    // select default address
    let addressSelect = $('#address_id');
    if (addressSelect.find('option').length > 1){
        addressSelect.find('option').attr('selected', false);
        let defaultOpt = addressSelect.find('option:nth-child(2)');
        defaultOpt.attr('selected', true);
        calcShippingCost(defaultOpt.val(), 'initial');
    }

    $(document).on('change', 'select[name=address_id]', function () {
        if($(this).val() !== ''){
            calcShippingCost($(this).val(), 'initial');
        }else{
            // reset view
            $('#selectedAddress').addClass('d-none');
            $('#totalShippingCost').html('وابسته به آدرس');
            $('#shippingMethodName').html('وابسته به آدرس');
            $('#shippingMethodImage').addClass('d-none');
            $('.shop-item-free-limits, .shop-item-shipping').html('');
        }
    });

    // wallet check
    $('#wallet_check').on('change', function () {
        let balance = parseInt($('#balance').val());
        let priceToPay = parseInt($('#priceToPay').val());
        let price;
        if ($(this).is(":checked")) {
            if(balance >= priceToPay){
                price = 0;
            }else{
                price = priceToPay - balance;
            }
        } else {
            price = priceToPay;
        }
        $('.price-to-pay').html(number_3_3(price));
    });

    // address form validation
    $("#addressForm").validate({
        errorClass: "is-invalid",
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.appendTo(element.parents('.form-group'));
        },
        submitHandler: function (form) {
            $('#btnAddressSubmit,#btnSubmit').addClass('loading');
            form.submit();
        },
        rules: {
            state: {
                required: true,
            },
            city: {
                required: true,
            },
            post_code: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            address: {
                required: true,
                minlength: 8,
            },
            phone: {
                required: true,
                number: true,
                minlength: 11,
                maxlength: 11
            },
        },
        messages: {
            state: {
                required: "استان را انتخاب کنید.",
            },
            city: {
                required: "شهر را انتخاب کنید.",
            },
            post_code: {
                required: "کد پستی را وارد کنید.",
                number: "کد پستی باید یک مقدار عددی باشد",
                minlength: "کد پستی باید 10 رقم باشد",
                maxlength: "کد پستی باید 10 رقم باشد",
            },
            phone: {
                required: "تلفن را وارد کنید.",
                number: "شماره تلفن باید یک مقدار عددی باشد",
                minlength: "شماره تلفن باید 11 رقم باشد",
                maxlength: "شماره تلفن باید 11 رقم باشد",
            },
            address: {
                required: "آدرس را وارد کنید.",
                minlength: "آدرس خیلی کوتاه است",
            },
        }
    });
});

function calcShippingCost(addressId, selectedShippingMethod) {

    let data = new FormData();
    data.append('address_id', addressId);
    data.append('selected_shipping_method', selectedShippingMethod);
    loader.fadeIn('fast');

    $.ajax({
        method: 'POST',
        url: '/cart/calc-shipping-cost/',
        data: data,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': _token},
        error: function (e) {
            console.error(e);
            loader.fadeOut('fast');
            Swal.fire({
                icon: "error",
                text: "مشکلی پیش آمد، لطفا دوباره سعی کنید."
            });
        }
    }).done(function (data) {
        
        $('.shop-item-shipping,.shop-item-free-limits').html('');

        if (data['status'] === 'success') {
            if (data['shipping_cost'] == 0){
                // when it is on coupon
                if(data['is_coupon_valid']) {
                    $('#totalShippingCost').html("<span class='text-success'>بر عهده مشتری در زمان تحویل تسویه می گردد</span>");
                } else {
                    $('#totalShippingCost').html("<span class='text-success'>رایگان</span>");
                }
            }else{
                $('#totalShippingCost').html(number_3_3(data['shipping_cost']) + ' تومان');
            }

            // display address details
            $('#selectedAddress').removeClass('d-none');
            $('#addressCity').html(data['address']['province'] + ' - ' + data['address']['city']);
            $('#addressPostCode').html(data['address']['post_code']);
            $('#addressPhone').html(data['address']['phone']);
            $('#addressFullName').html(data['address']['full_name']);
            $('#addressAddress').html(data['address']['address']);

            let shippingImageUrl = '';
            let shippingImageName = '';
            let shippingImage = $('#shippingMethodImage');
            let shippingName = $('#shippingMethodName');
            let freightageElement = $('.freightage-accordion-item');
            let postElement = $('.post-accordion-item');
            let weightFreightageAlertCoupon = $('.freightage-alert-body-coupon');
            let weightFreightageAlert = $('.freightage-alert-body');
            let totalWeightElement = $('.total-weight');
            let totalPriceWithoutDiscount = $('.total-price-without-discount');
            let totalDiscount = $('.total-discount');

            // set total price without discount
            totalPriceWithoutDiscount.html(number_3_3(data['total_price_without_discount']));

            // set total discount
            totalDiscount.html(number_3_3(data['total_discount']));

            // set total weight
            totalWeightElement.html(parseInt(data['total_weight']) / 1000);
            
            if (data['shipping_method'] === 'post'){
                shippingImageUrl = $('#shippingMethodImagePost').val();
                shippingImageName = $('#shippingMethodNamePost').val();

                postElement.find('label').removeClass('collapsed');
                freightageElement.find('label').addClass('collapsed');
                
                postElement.find('label').attr('aria-expanded', true);
                freightageElement.find('label').attr('aria-expanded', false);

                postElement.find('#collapseTwo').addClass('show');
                freightageElement.find('#collapseOne').removeClass('show');

                postElement.find('input').prop('checked', true);
                freightageElement.find('input').prop('checked', false);
                
            } else if (data['shipping_method'] === 'freightage'){
                shippingImageUrl = $('#shippingMethodImageFreightage').val();
                shippingImageName = $('#shippingMethodNameFreightage').val();

                freightageElement.find('label').removeClass('collapsed');
                postElement.find('label').addClass('collapsed');

                freightageElement.find('label').attr('aria-expanded', true);
                postElement.find('label').attr('aria-expanded', false);

                freightageElement.find('#collapseOne').addClass('show');
                postElement.find('#collapseTwo').removeClass('show');

                freightageElement.find('input').prop('checked', true);
                postElement.find('input').prop('checked', false);
            } 

            if(data['is_coupon_valid']) {
                if(selectedShippingMethod === 'post' && parseInt(data['total_weight']) >= 40000) {
                    weightFreightageAlertCoupon.removeClass('d-none');
                    
                    weightFreightageAlertCoupon.find('.freightage-alert-weight').html(parseInt(data['total_weight']) / 1000);
                    weightFreightageAlertCoupon.find('.freightage-alert-price').html(data['shipping_cost']);

                    Swal.fire({
                        icon: "error",
                        text: `هزینه ارسال ${number_3_3(data['total_weight']/1000)} کیلوگرم تا درب منزل از طریق پست ${number_3_3(data['shipping_cost'])} تومان می باشد، اما اگر گزینه ارسال با باربری انتخاب شود، 60 تا 80 درصد در هزینه ارسال صرفه جویی می گردد، ضمنا برنج شما سریع تر و ایمن تر به دست شما خواهد رسید.`
                    });
                    $(window).scrollTop(0);

                } else {
                    weightFreightageAlertCoupon.addClass('d-none');
                }
            } else {
                if(selectedShippingMethod === 'post' && parseInt(data['total_weight']) >= 40000) {
                    weightFreightageAlert.removeClass('d-none');
                    
                    weightFreightageAlert.find('.freightage-alert-weight').html(parseInt(data['total_weight']) / 1000);
                    weightFreightageAlert.find('.freightage-alert-price').html(data['shipping_cost']);

                    Swal.fire({
                        icon: "error",
                        text: `هزینه ارسال ${number_3_3(data['total_weight']/1000)} کیلوگرم تا درب منزل از طریق پست ${number_3_3(data['shipping_cost'])} تومان می باشد، اما اگر گزینه ارسال با باربری انتخاب شود ارسال بار ایمن تر، سریع تر و رایگان خواهد بود!`
                    });
                    $(window).scrollTop(0);

                } else {
                    weightFreightageAlert.addClass('d-none');
                }
            }

            // display shipping image
            if (shippingImageUrl === ''){
                shippingImage.addClass('d-none');
                shippingName.html('وابسته به آدرس');
            }else{
                shippingImage.attr('src',shippingImageUrl).removeClass('d-none');
                shippingName.html(shippingImageName);
            }

            if (data['shipping_method'] === 'none'){
                $('#btnSubmitPay').prop('disabled',true);
                shippingName.html("<span class='text-danger'>امکان ارسال وجود ندارد</span>");
                $('#totalShippingCost').html("<span class='text-danger'>امکان ارسال وجود ندارد</span>");

                Swal.fire({
                    icon: "error",
                    text: "هیچ روش ارسالی برای شهر انتخابی شما وجود ندارد، لطفا به مدیر سایت اطلاع دهید!"
                });
            }else{
                $('#btnSubmitPay').prop('disabled',false);
            }

            // display price to pay
            $('.price-to-pay').html(number_3_3(data['price_to_pay']));
            $('#priceToPay').val(data['price_to_pay']);

        } else {
            Swal.fire({
                icon: "error",
                text: "مشکلی پیش آمد، لطفا دوباره سعی کنید."
            });
        }
    }).always(function () {
        $('#wallet_check').prop('checked',false);
        loader.fadeOut('fast');
    });

    // uncheck tipax
    let tipaxCheck = $('#tipax_check');
    if (tipaxCheck){
        tipaxCheck.prop('checked',false);
    }

}

$(document).on('change','#tipax_check', function (e) {
    let check = $(this).is(":checked");
    //totalShippingCost
    if (check){
        $('#totalShippingCost').html('0');
        $('#shippingMethodImage').addClass('d-none');
        $('#shippingMethodName').html($('#shippingMethodNameTipax').val());

        // price to pay
        let priceToPay = parseInt($('#basePriceToPay').val());
       
        $('.price-to-pay').html(number_3_3(priceToPay));
    }else{

        let addressId = $('#address_id').val();
        calcShippingCost(addressId, 'initial');

    }
});

$(document).on('click','.accordion-item', function (e) {
    let addressId = $('#address_id').val();

    let selectedShippingMethod = $(e.target).closest('.accordion-item').hasClass('freightage-accordion-item') ? 'freightage' : 'post';

    calcShippingCost(addressId, selectedShippingMethod);
});
