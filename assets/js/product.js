// init gallery thumbs swiper
const galleryThumbsSwiper = new Swiper('#galleryThumbsSwiper', {
    changeDirection: 'rtl',
    spaceBetween: 10,
    slidesPerView: 4.5,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
        1460: {
            slidesPerView: 6,
        },
        992: {
            slidesPerView: 5,
        },
        768: {
            slidesPerView: 9,
        },
        576: {
            slidesPerView:7,
        },
        480: {
            slidesPerView:6,
        }
    }
});

// init gallery swiper
const gallerySwiper = new Swiper('#gallerySwiper', {
    changeDirection: 'rtl',
    slidesPerView: 1,
    spaceBetween: 0,
    thumbs: {
        swiper: galleryThumbsSwiper,
    },
    navigation: {
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
        enabled:false
    },
    breakpoints: {
        // when window width is >= 640px
        992: {
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        }
    }
});

// init similar products swiper
new Swiper('.similar-products-swiper', {
    changeDirection: 'rtl',
    slidesPerView: 1.5,
    spaceBetween: 12,
    freeMode: true,
    navigation:{
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
        enabled:false
    },
    breakpoints: {
        1240: {
            slidesPerView: 5,
            freeMode: false,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        },
        880: {
            slidesPerView:4,
            freeMode: false,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        },
        768: {
            freeMode: false,
            slidesPerView: 3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        }
    }
});


// see more attribute button
$(document).on('click','.see-more-attr',function (){
    let btn = $(this);
    let list = $('.attributes-list');
    if(list.hasClass('open')){
        list.removeClass('open');
        btn.html("<i class='icon-plus'></i><span>مشاهده بیشتر</span>");
    }else{
        list.addClass('open');
        btn.html("<i class='icon-minus'></i><span>مشاهده کمتر</span>");
    }
});


// card increase/decrease buttons
$('.quantity-box .increase').on('click',function () {
    let quantity = $('.quantity-box').find('#quantity');
    quantity.html(parseInt(quantity.html()) + 1);
});
$('.quantity-box .decrease').on('click',function () {
    let quantity = $('.quantity-box').find('#quantity');
    let currentQuantity = parseInt(quantity.html());
    if (currentQuantity > 0){
        quantity.html(currentQuantity - 1);
    }
});


// add to cart button
$('#product-add-to-cart').on('click',function () {
    let btn = $(this);
    let quantityBox = $('.quantity-box');
    let quantity = parseInt(quantityBox.find('#quantity').html());
    let productId = btn.attr('data-id');
    let data = new FormData();
    data.append('product_id', productId);
    data.append('quantity', quantity);


    // check variations
    let colorRadio = $('input[name=color_id]');
    let sizeRadio = $('input[name=size_id]');
    let ok = true;
    if (colorRadio.val() !== undefined){
        if (!colorRadio.is(":checked")){
            ok = false;
            Swal.fire({
                icon:'warning',
                text: 'ابتدا رنگ محصول را انتخاب کنید.'
            });
        }else{
            data.append('color_id', $('input[name=color_id]:checked').val());
        }
    }
    if (sizeRadio.val() !== undefined){
        if (!sizeRadio.is(":checked")){
            ok = false;
            Swal.fire({
                icon:'warning',
                text: 'ابتدا سایز محصول را انتخاب کنید.'
            });
        }else{
            data.append('size_id', $('input[name=size_id]:checked').val());
        }
    }

    if (ok){
        btn.addClass('loading');
        $.ajax({
            method: 'POST',
            url: '/cart/add/',
            data: data,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': _token},
            error: function () {
                btn.removeClass('loading');
            }
        }).done(function (data) {
            console.log(data);
            if ($.trim(data['status']) === 'out_of_stock') {
                Toast.fire({
                    icon: 'error',
                    title: 'موجودی محصول کافی نیست!'
                })
            }else if($.trim(data['status']) === 'low_quantity'){
                Toast.fire({
                    icon: 'error',
                    title: data['msg']
                })
            } else if ($.trim(data['status']) === 'success') {
                Swal.fire({
                    title: "به سبد خریدتان اضافه شد",
                    text: "محصول مورد نظر با موفقیت به سبد خرید شما اضافه شد برای رزرو محصول سفارش خود را نهایی کنید.",
                    icon: 'success',
                    showCancelButton: true,
                    focusCancel: true,
                    confirmButtonText: 'نهایی کردن سفارش',
                    cancelButtonText: 'فهمیدم',
                    customClass: {
                        confirmButton: 'btn btn-success me-3',
                        cancelButton: 'btn btn-primary'
                    },
                    buttonsStyling:false
                }).then((result) => {
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
            btn.removeClass('loading');
        });
    }

});

// submit question
$(document).on('click','#submitQuestionBtn',function (){
    let btn = $(this);
    let form = $('#questionForm');
    let text = form.find('textarea[name=text]').val();
    if (text.length < 1){
        Toast.fire({
            icon: "warning",
            text: "لطفا متن پرسش را وارد کنید."
        });
    }else if(text.length < 10){
        Toast.fire({
            icon: "warning",
            text: "متن پرسش خیلی کوتاه است."
        });
    }else{
        btn.addClass('loading');
        form.submit();
    }
});

// question response button
$(document).on('click','.btn-question-response',function (){
    let form = $('#questionForm');
    let btn = $(this);
    let parentId = btn.attr('data-response-id');
    form.find('#response_to').val(parentId);

    let modalEl = document.querySelector('#modalSubmitQuestion');
    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
});

// repeater field add icon click
$(document).on('click','.repeater-field-add',function (){
    let parent = $(this).parent('.repeater-field');
    addRowToRepeater(parent);
});

// repeater input enter event detector
$('.repeater-input').keypress(function(event){
    let keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        addRowToRepeater($(this).parent('.repeater-field'));
    }
});

// function to add new row to repeater
function addRowToRepeater(parent){
    let field = parent.find('input');
    let select = $('#' + parent.attr('data-select-id'));
    let errorMsg = parent.parent('div').find('.error-msg');
    let icon = parent.attr('data-icon');
    let iconClass = parent.attr('data-icon-class');

    if (field.val().length < 3){
        errorMsg.html('متن وارد شده باید حداقل 3 کاراکتر باشد.');
        return false;
    }else{
        errorMsg.html('');
    }

    // insert row
    let el = "<div class='d-flex align-items-center mt-2 pe-1 repeater-row'>\n" +
        "<i class='"+icon+" "+iconClass+" me-1'></i>\n" +
        "<span class='font-13 repeater-row-value'>"+field.val()+"</span>\n" +
        "<span class='text-muted ms-auto font-17 cursor-pointer repeater-remove-row'><i class='icon-trash-2'></i></span>\n" +
        "</div>";
    $(el).insertAfter(errorMsg);

    // add value to select
    select.append($('<option/>', {
        value: field.val(),
        text : field.val(),
        selected: true
    }));

    // clear input
    field.val('');
}

// remove repeater row
$(document).on('click','.repeater-remove-row',function (){
    let value = $(this).parent().find('.repeater-row-value').html();
    let select = $('#' + $(this).parent().parent().find('.repeater-field').attr('data-select-id'));
    select.find('option').each(function() {
        if ( $(this).val() == value ) {
            $(this).remove();
        }
    });
    $(this).parent().remove();
});

// score range change event
$(document).on('input','#score',function (){
    let score = $(this).val();
    let view = $('#selected_score');
    let error = $('#range_error');
    error.html('');

    switch (score){
        case '0':
            view.html('');
            error.html('این مقدار نمیتواند خالی باشد.');
            break;
        case '1':
            view.html('خیلی بد');
            break;
        case '2':
            view.html('بد');
            break;
        case '3':
            view.html('معمولی');
            break;
        case '4':
            view.html('خوب');
            break;
        case '5':
            view.html('عالی');
            break;
    }
})

// add comment
$(document).on('click','#addCommentBtn',function (e){
    let btn = $(this);
    let container = $('#commentForm');
    let comment = container.find('textarea[name=comment]');
    let score = $('#score');
    let scoreError = $('#range_error');
    let productId = container.find('input[name=product_id]').val();
    let strengths = $('#strengths');
    let weaknesses = $('#weaknesses');
    let anonymousCheck = $('#anonymous');
    let anonymous = !!anonymousCheck.is(":checked");


    // check score
    if (parseInt(score.val()) < 1 || parseInt(score.val()) > 5 || score.val() == ''){
        Toast.fire({
            icon: "warning",
            text: "لطفا امتیاز خود را مشخص کنید."
        });
        scoreError.html('وارد کردن این مقدار ضروری است.');
        e.preventDefault();
        return false;
    }

    // check comment field
     if(comment.val().length < 3){
        Toast.fire({
            icon: "warning",
            text: "متن دیدگاه حداقل باید 3 کاراکتر باشد."
        });
        e.preventDefault();
        return false;
    }

    btn.addClass('loading');

    let data = new FormData();
    data.append('product_id', productId);
    data.append('score', score.val());
    data.append('strengths', strengths.val());
    data.append('weaknesses', weaknesses.val());
    data.append('comment', comment.val());
    data.append('anonymous', anonymous);

    $.ajax({
        method: 'POST',
        url: '/panel/comment/add/',
        data: data,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': _token},
        error: function () {
            btn.removeClass('loading');
        }
    }).done(function (data) {
        if (data['status'] == 'success'){
            weaknesses.val('');
            strengths.val('');
            container.find('.repeater-input').val('');
            container.find('.repeater-row').remove();
            score.val('0');
            comment.val('');
            anonymousCheck.prop('checked',false);
            // hide modal
            let myModalEl = document.getElementById('modalAddComment');
            let modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();
        }
        Toast.fire({
            icon: data['status'],
            text: data['msg']
        });

    }).always(function () {
        btn.removeClass('loading');
    });


});

// add to cart button (product page)
$('#variation-add-to-cart').on('click',function () {
    addToCartFunc(this);
});

function addToCartFunc(btn) {
    let id = $(btn).attr('data-id');
    let data = new FormData();
    data.append('product_id', id);
    let colorRadio = $('input[name=color_id]');
    let sizeRadio = $('input[name=size_id]');
    let ok = true;

    if (colorRadio.val() !== undefined){
        if (!colorRadio.is(":checked")){
            ok = false;
            Swal.fire({
                icon:'warning',
                text: 'ابتدا رنگ محصول را انتخاب کنید.'
            });
        }else{
            data.append('color_id', $('input[name=color_id]:checked').val());
        }
    }

    if (sizeRadio.val() !== undefined){
        if (!sizeRadio.is(":checked")){
            ok = false;
            Swal.fire({
                icon:'warning',
                text: 'ابتدا سایز محصول را انتخاب کنید.'
            });
        }else{
            data.append('size_id', $('input[name=size_id]:checked').val());
        }
    }

    if (ok){
        $(btn).addClass('loading');
        $.ajax({
            method: 'POST',
            url: '/user/cart/add',
            data: data,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': _token},
            error: function () {
                $(btn).removeClass('loading');
            }
        }).done(function (data) {

            if ($.trim(data['status']) === 'success') {
                Swal.fire({
                    title:"به سبد خریدتان اضافه شد",
                    text: "اکنون چه کاری میخواهید انجام دهید؟",
                    buttons: ["ادامه خرید", "رفتن به سبد خرید"],
                    icon: "success",
                }).then((gotoCart) => {
                    if (gotoCart) {
                        window.location.replace('/user/cart');
                    }else{
                        window.location.reload();
                    }
                });

            }else if($.trim(data['status']) === 'inventory_not_found'){
                Swal.fire({
                    'icon':'error',
                    'text':'این محصول موقتا در دسترس نیست.',
                });
            }else if($.trim(data['status']) === 'out_of_stock'){
                Swal.fire({
                    'icon':'warning',
                    'text':'موجودی کالا با ویژگی های انتخاب شده به اتمام رسیده.',
                });
            }else if($.trim(data['status']) === 'error'){
                Swal.fire({
                    'icon':'error',
                    'text':'مشکلی پیش آمد، عملیات انجام نشد!',
                });
            }

        }).always(function () {
            $(btn).removeClass('loading');
        });
    }
}


// variation change event
$(document).on('change','.variations-fields input[type=radio]',function (){
    getVariationData();
});

$(document).ready(function (){
    if($('.variation-price-container').hasClass('need-onload')){
        getVariationData();
    }
});
function getVariationData(){
    let priceContainer = $('.variation-price-container');
    let colorId = $('input[name=color_id]:checked').val();
    let sizeId = $('input[name=size_id]:checked').val();
    let inventoryType  = $('#inventoryType');
    let productId  = inventoryType.attr('data-product-id');
    let valid = true;

    if (inventoryType.val() == 'color' && colorId == undefined){
        valid = false;
    }else if (inventoryType.val() == 'size' && sizeId == undefined){
        valid = false;
    }else if (inventoryType.val() =='color_size' && (colorId == undefined || sizeId == undefined)){
        valid = false;
    }

    let data = new FormData();
    data.append('inventory_type', inventoryType.val());
    data.append('product_id', productId);
    data.append('color_id', colorId);
    data.append('size_id', sizeId);

    if (valid){
        priceContainer.html("<span class='me-1'>قیمت آیتم انتخابی:</span>");
        priceContainer.addClass('opacity-50');

        // get inventory data
        $.ajax({
            method: 'POST',
            url: '/get-inventory/',
            data: data,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': _token},
            error: function () {
                priceContainer.hide();
            }
        }).done(function (data) {
            if (data['status'] == 'success'){

                // check stock
                if (data['inventory']['stock_quantity'] > 0){
                    let html = "<span class='fw-bold font-16 price'>" + number_3_3(data['inventory']['price']) + " تومان</span>";
                    priceContainer.append(html);
                    if (data['inventory']['sale_price'] != null){
                        priceContainer.html("<span class='me-1'>قیمت آیتم انتخابی:</span>");

                        html = "<span class='font-15 dash-on me-1'>" + number_3_3(data['inventory']['price']) + " تومان</span>";
                        html+= "<span class='fw-bold font-16 price'>" + number_3_3(data['inventory']['sale_price']) + " تومان</span>";

                        html+=  "<span class='font-14 rounded-pill bg-danger badge p-2 ms-1'>" + data['inventory']['discount_percent'] + "%</span>";
                        priceContainer.append(html);
                    }
                }else{
                    priceContainer.html('<span class="text-danger">آیتم انتخابی ناموجود</span>');
                }

            }else{
                priceContainer.append('<span class="text-danger">مشکلی پیش آمد</span>');
            }

        }).always(function () {
            priceContainer.removeClass('opacity-50');
        });

    }
}
