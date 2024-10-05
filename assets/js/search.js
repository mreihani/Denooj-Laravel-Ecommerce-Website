let searchInput = $('.search-input');
let resultContainer = $('.search-result-items');
let searchMoreLink = $('.search-more');
let searchRecommendation = $('.search-recommendation');
let searchIcon = $('.search-icon');
let searchClear = $('.search-clear');
let mobileSearchContainer = $('.mobile-search-container');
let searchXhr = null;

// search input focus
$(document).on('focus','.search-input',function (){
    $('.search-backdrop').fadeIn();
    $('.search-results').slideDown('fast');
});

// search backdrop click
$(document).on('click','.search-backdrop',function (){
    closeSearch();
});

function closeSearch(){
    $('.search-backdrop').hide();
    $('.search-results').hide('fast');
    searchClear.addClass('d-none');
    searchIcon.removeClass('d-none');
    resultContainer.html('');
    searchRecommendation.removeClass('d-none');
    searchInput.val('');
}
searchInput.on('input', function () {
    if ($(this).val().length > 1) {
        searchClear.removeClass('d-none');
        searchIcon.addClass('d-none');
        doSearch($(this).val());
    }
    if ($(this).val().length <= 1) {
        searchClear.addClass('d-none');
        searchIcon.removeClass('d-none');
        resultContainer.html('');
        searchRecommendation.removeClass('d-none');
    }
});

// clear search
$(document).on('click','.search-clear',function (){
    searchClear.addClass('d-none');
    searchIcon.removeClass('d-none');
    resultContainer.html('');
    searchInput.val('');
    searchRecommendation.removeClass('d-none');
});

$(document).on('click','.search-recommendation-item',function (){
    let query = $(this).html();
    searchInput.val(query);
    searchClear.removeClass('d-none');
    searchIcon.addClass('d-none');
    doSearch(query);
});

// mobile search close
$(document).on('click','.close-search',function (){
    mobileSearchContainer.removeClass('open');
    searchClear.addClass('d-none');
    searchIcon.removeClass('d-none');
    resultContainer.html('');
    searchInput.val('');
    searchRecommendation.removeClass('d-none');
    mobileSearchContainer.find('.search-results').hide();
});

// mobile search open
$(document).on('click','.mobile-search-open',function (){
    mobileSearchContainer.addClass('open');
});

function doSearch(query) {
    if (searchXhr) {
        searchXhr.abort()
    }
    let container = $('.search-container');
    container.addClass('loading');
    searchRecommendation.addClass('d-none');
    resultContainer.html('');

    searchXhr = $.ajax({
        method: 'GET',
        url: '/search?q=' + query,
        processData: false,
        contentType: false,
        error: function () {
            container.removeClass('loading');
        }
    }).done(function (data) {
        if (data.length < 1) {
            searchMoreLink.addClass('d-none');
            resultContainer.append('<p class="font-14 m-3">هیچ نتیجه ای یافت نشد.</p>');
            searchRecommendation.removeClass('d-none');
            searchMoreLink.addClass('d-none');
        } else {
            if (data.length === 6){
                searchMoreLink.removeClass('d-none').attr('href', '/products?filter[search]=' + query);
            }
            resultContainer.html('');
            $(data).each(function (index, item) {
                let imageUrl = '/images/default.jpg';
                if (item['searchable']['image'] != null){
                    imageUrl = '/storage' + item['searchable']['image']['thumb'];
                }
                let price = item['searchable']['price'];
                let salePrice = item['searchable']['sale_price'];
                let productType = item['searchable']['product_type'];
                let inStock = item['searchable']['in_stock'];
                let priceClass = '';
                let salePriceClass = 'd-none';
                let priceSection = "";




                if (!inStock){
                    priceSection = "<span class='price me-3'>ناموجود</span>";
                }else{

                    if (productType == 'variation'){
                        price = item['searchable']['final_price'];
                        priceSection = "<span class='price "+priceClass+" me-3'>"+number_3_3(price)+" تومان</span>";

                    }else{
                        if (salePrice !== null && salePrice != '0'){
                            priceClass = 'dash-on';
                            salePriceClass = '';
                            priceSection = "<span class='price "+priceClass+" me-3'>"+number_3_3(price)+" تومان</span>" +
                                "<span class='price color-green "+salePriceClass+"'>"+number_3_3(salePrice)+" تومان</span>";
                        }else{
                            priceSection = "<span class='price me-3'>"+number_3_3(price)+" تومان</span>";
                        }
                    }
                }


                let el = "<a href='" + item['url'] + "' class='h-product-item'>" +
                    "<div class='h-product-item-thumb'>" +
                    "<img src='"+imageUrl+"' alt='product'>" +
                    "</div>" +
                    "<div class='h-product-item-content'>" +
                    "<h5 class='title'>" + item['searchable']['title'] + "</h5>" +
                    "<div class='d-flex'>" +
                    priceSection +
                    "</div>" +
                    "</div>" +
                    "</a>";
                resultContainer.append(el);
            });
        }


    }).always(function () {
        container.removeClass('loading');
    });
}
