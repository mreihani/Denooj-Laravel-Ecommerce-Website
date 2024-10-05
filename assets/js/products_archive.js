/************ init jquery pjax ***************/

$(document).pjax('[data-pjax] a, a[data-pjax]', '#pjax-container','.pjax-container');
$.pjax.defaults.timeout = 5000;

$(document).on('pjax:send', function (e) {
    loader.fadeIn('fast');
});

$(document).on('pjax:timeout', function (event) {
    event.preventDefault()
});

$(document).on('pjax:error', function (xhr, textStatus, error) {
    console.error('pjax error: ' + error);
});

$(document).on('pjax:end', function (e) {
    loader.fadeOut('fast');
    $('.filters-sidebar').removeClass('show');
    $('.product-orders').removeClass('show');


    // check price rage
    if (getUrlParameter('filter[price]') === false){
        // reset range slider
        checkPriceRangOnLoad(true);

        // hide clear button
        priceRangeBtnClear.addClass('d-none');
    }else{
        // show clear button
        priceRangeBtnClear.removeClass('d-none');
    }

    // check clear all filter button
    // Get the search parameters from the current URL
    const params = new URLSearchParams(window.location.search);
    if (params.size > 0) {
        // there is some filters
        $('#btnRemoveAllFilters').removeClass('d-none');
    }else{
        $('#btnRemoveAllFilters').addClass('d-none');
    }

});

$(document).on('pjax:success', function (e) {
});


// init price range slider
let priceRange = "";
let rangeSlider = $('.range-slider');
let priceRangeBtn = $('#priceRangeBtn');
let priceRangeBtnClear = $('#priceRangeBtnClear');
let maxPriceRange = parseInt($('#maxPriceRange').val());


function initJRange(width) {
    rangeSlider.jRange({
        from: 0,
        to: maxPriceRange,
        step: 50,
        width: width,
        showLabels: false,
        isRange: true,
        onstatechange: function (val) {
            priceRange = val;

            let num = String(val).split(',');
            $('#range_min').html(number_3_3(num[0]));
            $('#range_max').html(number_3_3(num[1]));

            // enable-disable filter buttons
            if (parseInt(num[0]) !== 0 || parseInt(num[1]) !== maxPriceRange) {
                priceRangeBtn.removeClass('disabled');
            } else {
                priceRangeBtn.addClass('disabled');
            }
        }
    });

    rangeSlider.jRange('setValue', '0,' + maxPriceRange);
}


/******** filters click *****/

$(document).on('click', '#priceRangeBtn', function (e) {
    e.preventDefault();
    sortByParam('filter[price]', priceRange);
});

$(document).on('click', '#priceRangeBtnClear', function (e) {
    e.preventDefault();
    removeFilterFromUrl('filter[price]');
});



$(document).on('click', '#btnRemoveAllFilters', function (e) {
    removeAllFilters();
});

$(document).on('change', '#checkAvailable', function () {
    if (this.checked) {
        sortByParam('filter[available]', 'true');
    } else {
        removeFilterFromUrl('filter[available]');
    }
});


$(document).on('change', '.attribute-check', function () {
    let attrCode = $(this).attr('data-attribute-code');
    let parent = $(".attribute-check[data-attribute-code='"+attrCode+"']").parents('.accordion-item').find('.accordion-button');
    let filterName = 'filter[' + 'attribute-'+attrCode + ']';
    let attributeCheckedValues = $(".attribute-check[data-attribute-code='"+attrCode+"']:checkbox:checked").map(function(){
        return $(this).val();
    }).get();
    if (attributeCheckedValues.length > 0) {
        parent.addClass('changed');
        sortByParam(filterName, attributeCheckedValues);
    } else {
        parent.removeClass('changed');
        removeFilterFromUrl(filterName);
    }
});


$(document).on('change', '#checkDiscounted', function () {
    if (this.checked) {
        sortByParam('filter[hasDiscount]', 'true');
    } else {
        removeFilterFromUrl('filter[hasDiscount]');
    }
});


$(document).on('click', '#btnResultSearch', function () {
    let inp = $('#inpResultSearch');
    let btn = $(this);
    if (inp.val().length > 1) {
        sortByParam('filter[search]', inp.val());
        btn.removeClass('btn-primary').addClass('btn-danger').html('<i class="icon-x"></i>');
        btn.attr('id','btnResultSearchClear');
    }
});

$(document).on('click', '#btnResultSearchClear', function () {
    clearSearchFilter();
});

function clearSearchFilter(){
    let inp = $('#inpResultSearch');
    let btn = $("#btnResultSearchClear");
    btn.removeClass('btn-danger').addClass('btn-primary').html('<i class="icon-search"></i>');
    inp.val('');
    removeFilterFromUrl('filter[search]');
    btn.attr('id','btnResultSearch');
}


$(document).on('click', '.custom-pagination a', function (e) {
    e.preventDefault();
    let url = $(this).attr('href');
    let pageNum = url.split('=');
    sortByParam('page', pageNum[1]);
});


/******** sorts ***************/

$(document).on('click', '#sortNewest', function (e) {
    e.preventDefault();
    sortByParam('sort', '-created_at');
});

$(document).on('click', '#sortOldest', function (e) {
    e.preventDefault();
    sortByParam('sort', 'created_at');
});

$(document).on('click', '#sortExpensive', function (e) {
    e.preventDefault();
    sortByParam('sort', '-price');
});

$(document).on('click', '#sortCheapest', function (e) {
    e.preventDefault();
    sortByParam('sort', 'price');
});

$(document).on('click', '#sortBestSelling', function (e) {
    e.preventDefault();
    sortByParam('sort', '-sell_count');
});

$(document).on('click', '#sortDiscount', function (e) {
    e.preventDefault();
    sortByParam('sort', '-discount_percent');
});



/********** categories ********/
$(document).on('click', '.filter-links a', function (e) {
    e.preventDefault();
    changeBaseUrl($(this).attr('href'));
});


function changeBaseUrl(url) {
    let finalUrl = "";
    let fullUrl = window.location.href;
    let parts = fullUrl.split('?');

    if (parts.length > 1) {
        finalUrl = url + '?' + parts[1];
    } else {
        finalUrl = url;
    }
    $.pjax({url: finalUrl, container: '#pjax-container'});
}

function removeAllFilters() {
    let fullUrl = window.location.href;
    let parts = fullUrl.split('?');
    if (parts.length > 1){
        $.pjax({url: parts[0], container: '#pjax-container'});
    }

    // hide btn
    $('#btnRemoveAllFilters').addClass('d-none');

    // uncheck discount and available filters
    $('#checkAvailable,#checkDiscounted').prop('checked',false);

    // clear search filter
    clearSearchFilter();

    // clear attribute filters
    $('.attribute-check').prop('checked',false);
    $('.accordion-button').removeClass('changed');
}


function removeFilterFromUrl(filter) {
    // check filter if exists
    if (getUrlParameter(filter) !== false){
        let finalUrl = "";
        let fullUrl = window.location.href;
        let parts = fullUrl.split('?');
        let params = parts[1].split('&');

        $(params).each(function (index, item) {
            if (item.includes(filter)) {
                params.splice(index, 1);
            }
        });

        finalUrl = parts[0] + "?" + params.join('&');
        $.pjax({url: finalUrl, container: '#pjax-container'});
    }
}

function sortByParam(filter, value) {
    let finalUrl = "";
    let fullUrl = window.location.href;
    let parts = fullUrl.split('?');

    if (parts.length > 1) {
        // location already has parameters
        let params = parts[1].split('&');

        if (parts[1].includes(filter)) {
            // location already has given filter

            // remove current filter from
            $(params).each(function (index, item) {
                if (item.includes(filter)) {
                    params.splice(index, 1);
                }
            });


            if (params.length > 1) {
                // multiple params
                finalUrl = parts[0] + "?" + filter + "=" + value + "&" + params.join('&');

            } else {
                // only has one param
                finalUrl = parts[0] + "?" + filter + "=" + value + "&" + params.join('&');
            }

        } else {
            // new filter added
            finalUrl = parts[0] + "?" + filter + "=" + value + "&" + params.join('&');
        }


    } else {
        finalUrl = fullUrl + "?" + filter + "=" + value;
    }

    $.pjax({url: finalUrl, container: '#pjax-container'});
}

function checkPriceRangOnLoad(clear = false) {
    if (clear){
        rangeSlider.jRange('setValue', '0,' + maxPriceRange);
        priceRangeBtn.addClass('disabled');

    }else{
        let fullUrl = window.location.href;
        let parts = fullUrl.split('?');
        if (parts.length > 1) {
            let params = parts[1].split('&');
            $(params).each(function (index, item) {
                if (item.includes('filter[price]')) {
                    let split = item.split('=');
                    rangeSlider.jRange('setValue', split[1]);
                    priceRangeBtnClear.removeClass('d-none');
                }
            });
        }
    }
}

function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
}


/******** orders and filters --> close - open *********/

$(document).on('click', '.cat-menu-item-toggle.main', function (e) {
    $('.category-collapse').collapse('hide');
});

$(document).on('click', '#filtersOpen', function () {
    $('.filters-sidebar').addClass('show');
});

$(document).on('click', '#closeFilters', function () {
    $('.filters-sidebar').removeClass('show');
});

$(document).on('click', '#ordersOpen', function () {
    $('.product-orders').addClass('show');
});

$(document).on('click', '#closeOrders', function () {
    $('.product-orders').removeClass('show');
});


$(document).ready(function () {

    if ((screen.width >= 992) && (screen.height >= 650)) {
        initJRange(200);
    } else {
        initJRange(270);
    }

    checkPriceRangOnLoad();

});

