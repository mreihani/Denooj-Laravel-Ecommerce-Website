let colorsSelect = $('#colors');
let sizesSelect = $('#sizes');
let productTypeSelect = $('#product_type');
let variationTypeSelect = $('#variation_type');
let btnGenerate = $('#generateVariations');
let removedColors = [];
let removedSizes = [];


// price validation
$(document).on('keyup keydown','.price-input', function(e) {
    let saleField = $(this).parent().parent().next('.col-lg-6').find('.sale-price-input');
    if(parseInt(saleField.val()) >= parseInt($(this).val())){
        let msg = "<small class='text-danger d-block mt-1'>باید کمتر از فیلد قیمت باشد.</small>";
        if(!saleField.parents('.col-lg-6').find('small').length){
            saleField.parents('.col-lg-6').append(msg);
        }
    }else{
        saleField.parents('.col-lg-6').find('small').remove();
    }
});

// sale price validation
$(document).on('keyup keydown','.sale-price-input', function(e) {
    let priceField = $(this).parent().parent().prev('.col-lg-6').find('.price-input');
    if(parseInt(priceField.val()) <= parseInt($(this).val())){
        let msg = "<small class='text-danger d-block mt-1'>باید کمتر از فیلد قیمت باشد.</small>";
        if(!$(this).parents('.col-lg-6').find('small').length){
            $(this).parents('.col-lg-6').append(msg);
        }
    }else{
        $(this).parents('.col-lg-6').find('small').remove();
    }
});

// product type change
productTypeSelect.change(function () {
    let triggerEl;
    if ($(this).val() == 'variation') {
        // change active tab
        triggerEl = document.querySelector('#productTabs button[data-bs-target="#navs-inventory"]')
        new bootstrap.Tab(triggerEl).show()
        // update ui
        $('.variation-product-fields').removeClass('d-none');
        $('.simple-product-field').addClass('d-none');
        $('#price').prop('required', false).val('0');
    } else {
        // update ui
        $('.variation-product-fields').addClass('d-none');
        $('.simple-product-field').removeClass('d-none');
        $('#price').prop('required', true);
    }
});

// colors unselect
colorsSelect.on('select2:unselect', function (e) {
    let colorVal = e.params.data.id;
    removedColors.push(colorVal);
})

// sizes unselect
sizesSelect.on('select2:unselect', function (e) {
    let sizeCode = e.params.data.id;
    removedSizes.push(sizeCode);
})

// change variation type
let preTypeVal = variationTypeSelect.val();
variationTypeSelect.change(function (e) {
    if (confirm('با تغییر این فیلد متغیر های وارد شده پاک میشود! آیا مطمئن هستید؟')){
        let type = $(this).val();
        let sizesContainer = $('#sizesSelectContainer')
        let colorsContainer = $('#colorsSelectContainer')
        switch (type) {
            case "color":
                colorsContainer.removeClass('d-none');
                sizesContainer.addClass('d-none');
                break;
            case "size":
                colorsContainer.addClass('d-none');
                sizesContainer.removeClass('d-none');
                break;
            case "color_size":
                colorsContainer.removeClass('d-none');
                sizesContainer.removeClass('d-none');
                break;
            default:
                colorsContainer.addClass('d-none');
                sizesContainer.addClass('d-none');
                break;
        }

        // reset fields
        $('#variationsAccordion').html('');
        colorsSelect.val(null).trigger('change');
        sizesSelect.val(null).trigger('change');
    }else{
        $(this).val(preTypeVal);
    }
})

btnGenerate.click(function () {
    generateVariations();
});


// variation remove
$(document).on('click','.btn-remove-variation',function (){
    let type = $(this).attr('data-type');
    let code = $(this).attr('data-variation-code');
    if (type === 'color') code = code.split('|')[0];
    removeVariation(type,code);
});

function removeVariation(type,code){
    $("."+ type + "_variation_accordion_" + code).remove();

    // remove from dropdown list
    let selectId = "#" + type + "s";
    let option = $(selectId + " option[value^='"+code+"']");
    option.prop('selected', false);
    $(selectId
    ).trigger('change.select2');
}

function generateVariations() {
    let container = $('#variationsAccordion');
    let type = variationTypeSelect.val();
    let allColors = colorsSelect.select2('data');
    let allSizes = sizesSelect.select2('data');
    let fieldsPrefix = 'color_';
    let fieldsRow = '';

    // check removed items
    removedSizes.forEach(function (sizeCode){
        removeVariation('size',sizeCode);
    });
    removedSizes = [];
    removedColors.forEach(function (colorCode){
        let arr = colorCode.split('|');
        removeVariation('color',arr[0]);
    });
    removedColors = [];

    switch (type) {
        case "color":
        case "size":
            let optionArray = allColors;
            let allowGenerate = allColors.length;
            if (type === 'size'){
                optionArray = allSizes;
                fieldsPrefix = 'size_';
                allowGenerate = allSizes.length;
            }
            if (allowGenerate) {
                $(optionArray).each(function (index, option) {
                    let code = option['id'];
                    let colorHex = '';
                    if (type === 'color'){
                        let arr = code.split('|');
                        code = arr[0];
                        colorHex = arr[1];
                    }
                    let name = option['text'];
                    let accordionBodyId = Math.floor(Math.random() * 90000) + 10000;

                    // prevent generation duplicate accordion
                    let exists = $('.' +type+ '_variation_accordion_' + code);
                    if (!exists.length){
                        console.log("code: " + code);
                        // generate accordion
                        let accordionEl = generateAccordionItem(code,name,type,accordionBodyId,'#variationsAccordion','',colorHex);
                        container.append(accordionEl);

                        // generate fields
                        fieldsRow = generateAccordionFields(fieldsPrefix, code);
                        $("#accordion_body_" + accordionBodyId).append(fieldsRow);
                    }
                });

            }
            // remove items
            let startWith = type + "_variation_accordion_";
            let allAccordions = $( ".accordion-item[class^='"+startWith+"']" );
            $(allAccordions).each(function (index, option) {
                let id = $(option).attr('id');
                let itemId = id.replace(startWith,'');
                if (!optionArray.filter(e => e.id === itemId).length > 0) {
                    $('#' + startWith + itemId).remove();
                }
            });

            break;

        case "color_size":
            if (allColors.length && allSizes.length) {
                fieldsPrefix = 'colorsize_';

                // generate colors first
                $(allColors).each(function (index, option) {
                    let colorCode = option['id'];
                    let colorHex = '';
                    let arr = colorCode.split('|');
                    colorCode = arr[0];
                    colorHex = arr[1];

                    let colorName = option['text'];
                    let colorAccordionBodyId = Math.floor(Math.random() * 90000) + 10000;

                    // prevent generation duplicate accordion
                    let exists = $('.color_variation_accordion_' + colorCode);
                    if (!exists.length){
                        // generate color accordion
                        let colorAccordionEl = generateAccordionItem(colorCode,colorName,'color',colorAccordionBodyId,'#variationsAccordion','',colorHex);
                        container.append(colorAccordionEl);
                    }else{
                        colorAccordionBodyId = $(exists).find('.accordion-body').attr('id').replace('accordion_body_','');
                    }


                    // generate sizes accordion container if not exist
                    let sizeAccordion = $('#sizeVariationsAccordion' + colorCode);
                    if (!sizeAccordion.length){
                        sizeAccordion = "<div class='accordion mt-3 accordion-header-primary accordion-outlined' id='sizeVariationsAccordion"+colorCode+"'></div>";
                        $("#accordion_body_" + colorAccordionBodyId).append(sizeAccordion);
                    }


                    // generate sizes
                    $(allSizes).each(function (index, option) {
                        let sizeCode = option['id'];
                        let sizeName = option['text'];
                        let sizeAccordionBodyId = Math.floor(Math.random() * 90000) + 10000;

                        // prevent generation duplicate accordion
                        let exists = $('#sizeVariationsAccordion' + colorCode + ' .size_variation_accordion_' + sizeCode); // duplicate !!!!
                        if (!exists.length){
                            // generate size accordion
                            let sizeAccordionItemEl = generateAccordionItem(sizeCode,sizeName,'size',sizeAccordionBodyId,'#sizeVariationsAccordion' + colorCode,'mt-3 mb-0');
                            $('#sizeVariationsAccordion' + colorCode).append(sizeAccordionItemEl);

                            // generate fields
                            let code = sizeCode + "|" + colorCode;
                            fieldsRow = generateAccordionFields(fieldsPrefix, code);
                            $("#accordion_body_" + sizeAccordionBodyId).append(fieldsRow);


                        }

                    });

                });
            }
            break;
    }


}

function generateAccordionItem(code, name, type, accordionBodyId, parentId, classes = '',colorCode = '#ddd') {
    let colorSquare = "";
    if (type === 'color') colorSquare = "<span class='color-square' style='background-color: "+colorCode+"'></span>";

    return "<div class='card accordion-item " +type+ "_variation_accordion_" + code + " "+classes+"'>" +
        "<h2 class='accordion-header'>" +
        "<button type='button' class='accordion-button' data-bs-toggle='collapse' data-bs-target='#accordion-" + type + "-" + code + "' aria-expanded='true'>" +
        colorSquare +
        name + "<span class='btn-remove-variation btn btn-sm btn-label-danger ms-auto me-3 px-1' data-type='"+type+"' data-variation-code='"+code+"'><i class='bx bx-trash-alt'></i></span>" +
        "</button>" +
        "</h2>" +
        "<div id='accordion-" + type + "-" + code + "' class='accordion-collapse collapse' data-bs-parent='"+parentId+"'>" +
        "<div class='accordion-body' id='accordion_body_" + accordionBodyId + "'>" +
        "</div>" +
        "</div>" +
        "</div>";
}

function generateAccordionFields(fieldsPrefix, code) {
    let arr = code.split('|');
    let toggleId = arr[0];
    if (arr.length > 1){
        toggleId = arr[0] + "_" + arr[1];
    }

    return "<div class='row align-items-baseline mt-3'>" +
        "<div class='mb-3 col-lg-6'>" +
        "<label class='form-label' for='" + fieldsPrefix + code + "_price'>قیمت (ضروری)</label>" +
        "<div class='input-group'>" +
        "<input type='number' class='form-control price-input' id='" + fieldsPrefix + code + "_price' name='" + fieldsPrefix + code + "|_price' required>" +
        "<span class='input-group-text'>تومان</span>" +
        "</div>" +
        "</div>" +
        "<div class='mb-3 col-lg-6'>" +
        "<label class='form-label' for='" + fieldsPrefix + code + "_saleprice'>قیمت فروش ویژه (اختیاری)</label>" +
        "<div class='input-group'>" +
        "<input type='number' class='form-control sale-price-input' id='" + fieldsPrefix + code + "_saleprice' name='" + fieldsPrefix + code + "|_saleprice'>" +
        "<span class='input-group-text'>تومان</span>" +
        "</div>" +
        "</div>" +
        "<div class='mb-3 col-lg-6'>" +
        "<div class='form-check form-switch'>" +
        "<input class='form-check-input check-toggle' type='checkbox' data-toggle='#stockContainer" + toggleId + "' data-toggle-reverse='#stockStatusContainer" + toggleId + "' id='" + fieldsPrefix + code + "_managestock' name='" + fieldsPrefix + code + "|_managestock' >" +
        "<label class='form-check-label' for='manage_stock'>مدیریت موجودی</label>" +
        "</div>" +
        "</div>" +
        "<div id='stockContainer" + toggleId + "' class='mb-3 col-lg-6 d-none'>" +
        "<label class='form-label' for='" + fieldsPrefix + code + "_stock'>موجودی</label>" +
        "<input type='number' class='form-control' id='" + fieldsPrefix + code + "_stock' name='" + fieldsPrefix + code + "|_stock' value='0'>" +
        "</div>" +
        "<div class='mb-3 col-lg-6' id='stockStatusContainer" + toggleId + "'>" +
        "<label class='form-label' for='" + fieldsPrefix + code + "_stockstatus'>وضعیت موجودی</label>" +
        "<select class='form-select' name='" + fieldsPrefix + code + "|_stockstatus' id='" + fieldsPrefix + code + "_stockstatus'>" +
        "<option value='in_stock'>موجود در انبار</option>" +
        "<option value='out_of_stock'>ناموجود</option>" +
        "</select>" +
        "</div>" +
        "</div>";
}
