let _token = $('meta[name="csrf-token"]').attr('content');

// toast
const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

// banta ui switcher
$(document).on('change','.banta-ui-switcher',function (){
   let dataId = $(this).val();
   $('[data-banta-switcher]').addClass('d-none');
   $('[data-banta-switcher='+dataId+']').removeClass('d-none');
});

// banta checkbox toggle
$(document).on('change','.banta-check-switcher',function (){
    let dataSwitcher = $(this).attr('data-switcher');
    if ($(this).is(':checked')){
        $('#' + dataSwitcher).removeClass('d-none');
    }else{
        $('#' + dataSwitcher).addClass('d-none');
    }
});


// image file remove button click (edit pages)
$(document).on('click','.remove-image-file',function (){
    let btn = $(this);
    let imageUrl = $(this).attr('data-url');
    let inp = $('#' + $(this).attr('input-id'));
    let clearInp = $('#' + $(this).attr('data-input-id'));
    let img = $('#' + $(this).attr('image-id'));
    inp.val(imageUrl);
    img.remove();
    btn.remove();
    if (clearInp.length > 0){
        clearInp.val('');
    }
});

// table item delete button click
$(document).on('click','.delete-row,.btn-fore-delete',function (){
    let button = $(this);
    let message = button.attr('data-alert-message');
    if (message === undefined || message === null) message = 'این کار قابل بازگشت نخواهد بود!';

    Swal.fire({
        title: 'آیا مطمئنید؟',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-danger me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {

            if (button.hasClass('btn-fore-delete')){
                button.parent('form').submit();
            }else{
                button.find('form').submit();
            }
        }
    });
})

// duplicate product row
$(document).on('click','.duplicate-product',function (){
    let button = $(this);
    button.find('form').submit();
})

// edit pages delete button function
$(document).on('click','#edit-page-delete',function (){
    let button = $(this);
    let text = button.attr('data-alert-message');
    if (text === undefined || text === ''){
        text = 'این عمل قابل بازگشت نخواهد بود!';
    }
    Swal.fire({
        title: 'آیا مطمئنید؟',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-danger me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {

            button.prop('disabled',true);
            button.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span> در حال حذف');

            let modelId = button.attr('data-model-id');
            let model = button.attr('data-model');
            let data = new FormData();
            data.append('id',modelId);

            $.ajax({
                method: 'POST',
                processData: false,
                contentType: false,
                url: '/admin/'+model+'/ajax-delete/',
                data: data,
                headers: {'X-CSRF-TOKEN': _token},
                error:function (e) {
                    console.log(e);
                    button.prop('disabled',false);
                    button.html('حذف');
                }
            }).done(function (data) {
                if (data === 'success'){
                    window.location.href = '/admin/' + model;
                }

            }).always(function () {
                button.prop('disabled',false);
                button.html('حذف');
            });
        }
    });
})

// change order status bulk action
$(document).on('click','.orders-bulk-action',function (){
    let button = $(this);
    let message = button.attr('data-alert-message');
    if (message === undefined || message === null) message = 'این کار قابل بازگشت نخواهد بود!';

    Swal.fire({
        title: 'آیا مطمئنید؟',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، اعمال کن!',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-danger me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {

            if (button.hasClass('orders-bulk-action')){
                button.closest('form').submit();
            }else{
                button.find('form').submit();
            }
        }
    });
})

// add spinner to submit buttons on click
const mainForm = document.getElementById('mainForm');
if (typeof(mainForm) != 'undefined' && mainForm != null){
    mainForm.addEventListener('submit', function (event){
        event.preventDefault();
        let button = $('.submit-button');
        button.prop('disabled',true);
        button.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span> چند لحظه صبر کنید');
        button.parents('form').submit();
    });
}
const secondForm = document.getElementById('secondForm');
if (typeof(secondForm) != 'undefined' && secondForm != null){
    secondForm.addEventListener('submit', function (event){
        event.preventDefault();
        let button = $(secondForm).find('.submit-button');
        button.prop('disabled',true);
        button.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span> چند لحظه صبر کنید');
        button.parents('#secondForm').submit();
    });
}


let ajaxSubmitForms = $('.ajax-submit-form');
if (typeof(ajaxSubmitForms) != 'undefined' && ajaxSubmitForms != null){
    $(ajaxSubmitForms).each(function (i,form){
        $(form).on('submit',function (event){
            event.preventDefault();
            let button = $(form).find('.submit-button');
            button.prop('disabled',true);
            button.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span> چند لحظه صبر کنید');
            form.submit();
        });

    });
}



// trash empty button click
$(document).on('click','#btn-empty-trash',function (){
    let button = $(this);
    Swal.fire({
        title: 'آیا مطمئنید؟',
        text: "همه موارد موجود در سطل زباله برای همیشه حذف میشوند!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-danger me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            button.parent('form').submit();
        }
    });
})

// check collapse toogle
$(document).on('change','.check-toggle',function (){
    let toggleEl = $(this).attr('data-toggle');
    let toggleElReverse = $(this).attr('data-toggle-reverse');
    if($(this).is(':checked')){
        $(toggleEl).removeClass('d-none');
        $(toggleElReverse).addClass('d-none');
    }else{
        $(toggleEl).addClass('d-none');
        $(toggleElReverse).removeClass('d-none');
    }
});


$(document).on('click','.add-more-faq',function (){
    let container = $('#faq-items');
    let name = makeId(6);

    let el = "<div class='row align-items-end' id='faq_row_"+name+"'>";

    el += "<div class='mb-3 col-12'>" +
        "<label for='item_faq_"+name+"' class='form-label'>عنوان</label>" +
        "<input class='form-control' type='text' id='item_faq_"+name+"' name='item_faq_"+name+"[]'>" +
        "</div>";

    el += "<div class='mb-3 col-12'>" +
        "<label for='item_faq_"+name+"' class='form-label'>متن</label>" +
        "<textarea class='form-control' id='item_faq_"+name+"' name='item_faq_"+name+"[]'></textarea>" +
        "</div>";

    el += "<div class='mb-3 col-lg-2'><span class='btn btn-label-danger btn-remove-faq' data-delete='faq_row_"+name+"'><i class='bx bx-trash'></i></span></div>";

    el += "<div class='col-12'><hr></div></div>";
    container.append(el);
});

$(document).on('click','.btn-remove-faq',function (){
    let id = "#" + $(this).attr('data-delete');
    $(id).remove();
});

function makeId(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

// init select2
$(function () {
    const selectPicker = $('.selectpicker'),
        select2 = $('.select2'),
        select2Icons = $('.select2-icons');

    // Bootstrap Select
    // --------------------------------------------------------------------
    if (selectPicker.length) {
        selectPicker.selectpicker();
    }

    // Select2
    // --------------------------------------------------------------------

    // Default
    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>').select2({
                placeholder: 'انتخاب',
                dropdownParent: $this.parent()
            });
        });
    }

    // Select2 Icons
    if (select2Icons.length) {
        // custom template to render icons
        function renderIcons(option) {
            if (!option.id) {
                return option.text;
            }
            var $icon = "<i class='bx bxl-" + $(option.element).data('icon') + " me-2'></i>" + option.text;

            return $icon;
        }
        select2Icons.wrap('<div class="position-relative"></div>').select2({
            templateResult: renderIcons,
            templateSelection: renderIcons,
            escapeMarkup: function (es) {
                return es;
            }
        });
    }
});

// init tagify
(function () {
    // Basic
    //------------------------------------------------------
    const tagifyBasicEl = document.querySelector('.tagify-select');
    const tagifyStrengths = document.querySelector('.tagify-strengths');
    const tagifyWeaknesses = document.querySelector('.tagify-weaknesses');
    $(tagifyBasicEl).each(function (i,el){
        new Tagify(el, {
            originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
        })
    });
    new Tagify(tagifyStrengths, {
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
    });
    new Tagify(tagifyWeaknesses, {
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
    });

})();

// init editor
(function () {

    // init ckeditor
    let ckEditors = $('.ck-editor');
    $(ckEditors).each(function (i,ck){
        CKEDITOR.replace($(ck).prop('id'),{
            language : 'fa',
            uiColor : '#eeeeee',
            height : 300,
            toolbarCanCollapse : true,
            toolbarGroups : [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                { name: 'forms', groups: [ 'forms' ] },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                { name: 'links', groups: [ 'links' ] },
                { name: 'insert', groups: [ 'insert' ] },
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'colors', groups: [ 'colors' ] },
                { name: 'tools', groups: [ 'tools' ] },
                { name: 'others', groups: [ 'others' ] },
                { name: 'about', groups: [ 'about' ] }
            ],
            removeButtons : 'Save,NewPage,ExportPdf,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Checkbox,Superscript,Subscript,Anchor,Smiley,PageBreak,Iframe,Font,About'
        });
    });

    // init summernote editor
    let summernote = $('.summernote-editor');
    $(summernote).each(function (i,sn){
        let outputId = $(sn).attr('data-input-id');
        let output = $(outputId);
        $(sn).summernote({
            imageTitle: {
                specificAltField: true,
            },
            toolbar: [
                // [groupName, [list of button]]
                ['para', ['style', 'ul', 'ol', 'paragraph']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['color', ['color']],
                ['height', ['height']],
                ['insert', ['picture', 'link', 'video', 'table', 'hr']],
                ['misc', ['codeview', 'undo', 'redo']]
            ],
            popover: {
                image: [
                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']],
                    ['custom', ['imageTitle']],
                ],
            },
            callbacks: {
                onChange: function(contents, $editable) {
                    output.val(contents);
                }
            },
            placeholder: 'محتوا را وارد کنید',
            height: 400,
            lang: 'fa-IR',
        });
    });


    // init tinymce editor
    tinymce.init({
        selector: '.tinymceeditor',
        directionality : "rtl",
        menubar: false,
        height: "500",
        language: "fa",
        plugins: 'image media autosave code fullscreen link lists advlist visualblocks wordcount emoticons',
        toolbar1: 'undo redo  | restoredraft fullscreen visualblocks wordcount | fontsize styles',
        toolbar2: 'alignleft aligncenter alignright  | backcolor forecolor bold italic | link image media code | bullist numlist emoticons'
    });
    tinymce.init({
        selector: '.tinymceeditor-sm',
        directionality : "rtl",
        menubar: false,
        height: "300",
        language: "fa",
        plugins: 'image media autosave code fullscreen link lists advlist visualblocks wordcount emoticons',
        toolbar: 'alignleft aligncenter alignright | bullist numlist | backcolor forecolor bold italic link | fontsize styles',
    });
})();

// init color picker (pickr)
(function () {
    let colorPickerLocaleFa = {
        'ui:dialog': 'دیالوگ انتخاب رنگ',
        'btn:toggle': 'تغییر وضعیت دیالوگ انتخاب رنگ',
        'btn:swatch': 'نمونه رنگ',
        'btn:last-color': 'استفاده از رنگ قبلی',
        'btn:save': 'ذخیره',
        'btn:cancel': 'لغو',
        'btn:clear': 'پاک کردن'
    };

    let monolithPicker = $('.color-picker-monolith');
    // monolith
    if (monolithPicker) {
        $(monolithPicker).each(function (i,p){
            let defaultColor = $(p).attr('data-default-color');
            let input = $($(p).attr('data-input-id'));
            let rgbInput = $($(p).attr('data-rgb-input-id'));

            let picker = pickr.create({
                el: p,
                theme: 'monolith',
                default: defaultColor,
                swatches: [
                    'rgba(102, 108, 232, 1)',
                    'rgba(40, 208, 148, 1)',
                    'rgba(255, 73, 97, 1)',
                    'rgba(255, 145, 73, 1)',
                    'rgba(30, 159, 242, 1)'
                ],
                components: {

                    // Main components
                    preview: false,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        hex: true,
                        rgba: true,
                        hsla: false,
                        hsva: false,
                        cmyk: false,
                        input: true,
                        clear: true,
                        save: false
                    }
                },
                i18n: colorPickerLocaleFa
            });
            picker.on('change',function (color){
                let rgb = Math.round(color.toRGBA()[0]) + ',' + Math.round(color.toRGBA()[1])+ ',' + Math.round(color.toRGBA()[2]);
                let hex = color.toHEXA().toString();
                picker.applyColor(hex);

                if (input.length){
                    input.val(hex);
                }
                if (rgbInput.length){
                    rgbInput.val(rgb);
                }
            });
            picker.on('clear',function (instance){
                if (input.length){
                    input.val('');
                }
                if (rgbInput.length){
                    rgbInput.val('');
                }
            });
        });
    }

})();

// init drag and drop
const nestedSortableOptions = {
    group: 'parent',
    animation: 150,
    handle: '.accordion-button',
    draggable: '.accordion-item-container',
    ghostClass: "sortable-ghost",
    chosenClass: "sortable-chosen",
    dragClass: "sortable-drag",
    fallbackOnBody: true,
    invertSwap:true,
    swapThreshold: 0.65,
    onRemove: function (evt) {
        let parentId = $(evt.item).parent('.nested-scrollable').prev('.menu-item-accordion').attr('data-menu-item-id');
        if (parentId == undefined) parentId = "";

        // change parent id
        $(evt.item).find('.menu-item-accordion').attr('data-menu-item-parent',parentId);
    },
    onEnd: function (evt) {
        let items = $(evt.to).find('.accordion-item-container');
        if (evt.pullMode){
            items = $(evt.to).parent().find('.accordion-item-container');
        }
        $(items).each(function (i, el){
            let index = $(el).find('.menu-item-accordion').parent().index();
            let parentId = $(el).find('.menu-item-accordion').attr('data-menu-item-parent');
            $(el).find('.item-index-input').val(index + '_' + parentId);
        });
    },
};

(function () {
    let accordionItems = document.getElementById('accordionItems');
    if (accordionItems) {

        // level1 items
        Sortable.create(accordionItems, {
            group: 'parent',
            animation: 150,
            handle: '.accordion-button',
            draggable: '.accordion-item-container',
            ghostClass: "sortable-ghost",  // Class name for the drop placeholder
            chosenClass: "sortable-chosen",  // Class name for the chosen item
            dragClass: "sortable-drag",  // Class name for the dragging item
            onRemove: function (evt) {
                let parentId = $(evt.item).parent('.nested-scrollable').prev('.menu-item-accordion').attr('data-menu-item-id');

                // change parent id
                $(evt.item).find('.menu-item-accordion').attr('data-menu-item-parent',parentId);
            },

            onEnd: function (evt) {
                let items = $(evt.from).find('.accordion-item-container');
                $(items).each(function (i, el){
                    let index = $(el).find('.menu-item-accordion').parent().index();
                    let parentId = $(el).find('.menu-item-accordion').attr('data-menu-item-parent');

                    $(el).find('.item-index-input').val(index + '_' + parentId);
                });
            },
        });

        // nested Sortables
        let nestedSortables = $('.nested-scrollable');

        for (var i = 0; i < nestedSortables.length; i++) {
            new Sortable(nestedSortables[i], nestedSortableOptions);
        }
    }
})();

// init perfect scroll
document.addEventListener('DOMContentLoaded', function () {
    (function () {
        const verticalScroll = $('.vertical-scrollable');
        if (verticalScroll) {
            verticalScroll.each(function (i,el){
                new PerfectScrollbar(el, {
                    wheelPropagation: false
                });
            });
        }
    })();
});

// save menu item
$(document).on('click','.btn-menu-item-save',function (){
    let btn = $(this);
    let accordion = btn.parents('.menu-item-accordion');
    let accordionTitle = accordion.find('.title');
    let spinner = $(accordion).find('.spinner-border');
    let form = btn.parents('.menu-item-form');
    let menuItemId = form.attr('data-id');
    let titleField = form.find('.title-field');
    let linkField = form.find('.link-field');
    let validTitle = true, validLink = true;

    titleField.removeClass('is-invalid');
    linkField.removeClass('is-invalid');

    // check fields
    if (titleField.val().length < 1){
        titleField.addClass('is-invalid');
        validTitle = false;
    }
    if (linkField.val().length < 1){
        linkField.addClass('is-invalid');
        validLink = false;
    }

    // update menu item
    if (validTitle && validLink){
        spinner.removeClass('d-none');
        let data = new FormData();
        data.append('menu_item_id',menuItemId);
        data.append('title',titleField.val());
        data.append('link',linkField.val());

        $.ajax({
            method: 'POST',
            processData: false,
            contentType: false,
            url: '/admin/menu-items/update/',
            data: data,
            headers: {'X-CSRF-TOKEN': _token},
            error:function (e) {
                console.log(e);
                spinner.addClass('d-none');
            }
        }).done(function (data) {
            if (data['status'] === 'success'){
                accordionTitle.html(data['item']['title']);
                titleField.val(data['item']['title']);
                linkField.val(data['item']['link']);
                Toast.fire({
                    icon: 'success',
                    position: 'bottom-right',
                    text: "تغییرات با موفقیت ذخیره شد."
                })
            }else{
                Toast.fire({
                    icon: 'error',
                    position: 'top-left',
                    text: "مشکلی پیش آمد، عملیات انجام نشد!"
                })
            }

        }).always(function () {
            spinner.addClass('d-none');
        });
    }

});

// delete menu item
$(document).on('click','.btn-menu-item-delete',function (){
    let btn = $(this);
    let accordion = btn.parents('.accordion-item-container');
    let spinner = $(accordion).find('.spinner-border');
    let form = btn.parents('.menu-item-form');
    let menuItemId = form.attr('data-id');

    // check if item has sub items
    let subItemsCount = accordion.find('.nested-scrollable').find('.accordion-item-container').length;
    let needReload = false;
    let text = "";
    if (subItemsCount > 0) needReload = true;
    if (needReload) text = "حذف این آیتم نیاز به بارگذاری مجدد صفحه دارد!";


    Swal.fire({
        title: 'از حذف مطمئن هستید؟',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-danger me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            spinner.removeClass('d-none');
            let data = new FormData();
            data.append('menu_item_id',menuItemId);

            $.ajax({
                method: 'POST',
                processData: false,
                contentType: false,
                url: '/admin/menu-items/delete/',
                data: data,
                headers: {'X-CSRF-TOKEN': _token},
                error:function (e) {
                    console.log(e);
                    spinner.addClass('d-none');
                }
            }).done(function (data) {
                if (data){
                    if (needReload){
                        Toast.fire({
                            icon: 'success',
                            position: 'center',
                            timer:1500,
                            text: "آیتم منو با موفقیت حذف شد."
                        }).then(function (){
                            window.location.reload();
                        });
                    }else{
                        accordion.remove();
                        Toast.fire({
                            icon: 'success',
                            position: 'bottom-right',
                            text: "آیتم منو با موفقیت حذف شد."
                        });

                        // reorder menu items
                        let items = $('#accordionItems').find('.accordion-item-container');
                        $(items).each(function (i, el){
                            let index = $(el).find('.menu-item-accordion').parent().index();
                            let parentId = $(el).find('.menu-item-accordion').attr('data-menu-item-parent');
                            $(el).find('.item-index-input').val(index + '_' + parentId);
                        });

                        // update menu items in db
                        reorderMenuItem();
                    }

                }else{
                    Toast.fire({
                        icon: 'error',
                        position: 'top-left',
                        text: "مشکلی پیش آمد، آیتم حذف نشد!"
                    })
                }
            }).always(function () {
                spinner.addClass('d-none');
            });
        }
    });

});

// bulk selection toggle
$(document).on('change','.bulk-selection-check',function (){
    if ($(this).is(":checked")){
        $('.bulk-selection-check').prop('checked',true);
        $('.item-delete-check').parent('.form-check').removeClass('d-none');
        $('.delete-items-options').removeClass('d-none');
    }else{
        $('.bulk-selection-check').prop('checked',false);
        $('.item-delete-check').parent('.form-check').addClass('d-none');
        $('.delete-items-options').addClass('d-none');
    }
});

// bulk selection check all
$(document).on('change','.bulk-selection-check-all',function (){
    let selectedItemsContainer = $('.selected-items-to-delete');

    if ($(this).is(":checked")){
        $('.bulk-selection-check-all').prop('checked',true);

        $('.item-delete-check').prop('checked',true);
        let checks = $('.item-delete-check:checked');
        checks.each(function (i,check){
            let title = $(check).attr('data-item-title');
            let id = $(check).attr('data-item-id');
            let selectedItemsContainer = $('.selected-items-to-delete');
            selectedItemsContainer.append("<span id='item-label-"+id+"' class='me-2 font-12'>("+title+")</span>")
        });
    }else{
        $('.bulk-selection-check-all').prop('checked',false);

        $('.item-delete-check').prop('checked',false);
        selectedItemsContainer.html('');
    }
});

// accordion item check change
$(document).on('change','.item-delete-check',function (){
    let check = $(this);
    let title = check.attr('data-item-title');
    let id = check.attr('data-item-id');
    let selectedItemsContainer = $('.selected-items-to-delete');

    let checkAllCheck = $('.bulk-selection-check-all');
    let allCheckboxes = $('.item-delete-check');
    let allChecked = true;
    allCheckboxes.each(function (i,check){
        if (!$(check).is(":checked")){
            allChecked = false;
        }
    });
    if (allChecked){
        checkAllCheck.prop('checked',true);
    }else{
        checkAllCheck.prop('checked',false);
    }

    if (check.is(":checked")){
        selectedItemsContainer.append("<span id='item-label-"+id+"' class='me-2 font-12'>("+title+")</span>")
    }else{
        $('#item-label-' +id).remove();
    }
});

// btn delete selected items (bulk)
$(document).on('click','.btn-bulk-delete',function (e){
    e.preventDefault();
    let btn = $('.btn-bulk-delete');
    let spinner = btn.find('.spinner-border');
    let list = $('#accordionItems');
    let menuId = $('#menu_id').val();
    let selectedChecks = $('.item-delete-check:checked');
    let ids = [];

    // create menu items
    if(selectedChecks.length > 0){
        selectedChecks.each(function (i,check){
            let itemId = $(check).attr('data-item-id');
            ids.push(itemId);
        });
        Swal.fire({
            title: 'از حذف مطمئن هستید؟',
            text: "این عمل نیاز به بارگذاری مجدد صفحه دارد!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'بله، حذف کن!',
            cancelButtonText: 'انصراف',
            customClass: {
                confirmButton: 'btn btn-danger me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                list.addClass('is-loading');
                spinner.removeClass('d-none');
                btn.addClass('no-pointer-events');

                let data = new FormData();
                data.append('menu_id',menuId);
                data.append('ids',ids);

                $.ajax({
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    url: '/admin/menu-items/bulk-delete/',
                    data: data,
                    headers: {'X-CSRF-TOKEN': _token},
                    error:function (e) {
                        console.log(e);
                        list.removeClass('is-loading');
                        spinner.addClass('d-none');
                        btn.removeClass('no-pointer-events');
                    }
                }).done(function (data) {
                    if (data){
                        Toast.fire({
                            icon: 'success',
                            position: 'center',
                            timer:1500,
                            text: "آیتم ها با موفقیت حذف شدند."
                        }).then(function (){
                            window.location.reload();
                        });
                    }else{
                        Toast.fire({
                            icon: 'error',
                            text: "مشکلی پیش آمد، عملیات انجام نشد!"
                        })
                    }
                }).always(function () {
                    list.removeClass('is-loading');
                    spinner.addClass('d-none');
                    btn.removeClass('no-pointer-events');
                });
            }
        });
    }
});

// add custom menu item
$(document).on('click','.btn-add-menu-item',function (e){
    e.preventDefault();
    let btn = $(this);
    let form = btn.parent().parent('.custom-item-form');
    let menuId = form.find('input[name=menu_id]').val();
    let titleField = form.find('input[name=title]');
    let linkField = form.find('input[name=link]');
    let validTitle = true, validLink = true;

    titleField.removeClass('is-invalid');
    linkField.removeClass('is-invalid');

    // check fields
    if (titleField.val().length < 1){
        titleField.addClass('is-invalid');
        validTitle = false;
    }
    if (linkField.val().length < 1){
        linkField.addClass('is-invalid');
        validLink = false;
    }

    // create menu item
    if (validTitle && validLink){
        createNewMenuItem(menuId,titleField.val(),linkField.val(),btn,true);
    }
});

// add check list item to menu
$(document).on('click','.btn-checklist-to-menu',function (e){
    e.preventDefault();
    let btn = $(this);
    let checklist = $(btn.attr('data-list-id'));
    let menuId = checklist.find('input[name=menu_id]').val();

    let selectedChecks = checklist.find('.checklist-check:checked');


    // create menu items
    if(selectedChecks.length > 0){
        selectedChecks.each(function (i,check){
            let title = $(check).attr('data-item-title');
            let link = $(check).attr('data-item-link');
            createNewMenuItem(menuId,title,link,btn,false);
        });

        // clear checks
        checklist.find('.checklist-check').prop('checked',false);
        checklist.find('.checklist-check-all').prop('checked',false);
    }
});

// checklist check all
$(document).on('change','.checklist-check-all',function (){
    let list = $($(this).attr('data-list-id'));
    if ($(this).is(":checked")){
        list.find('.checklist-check').prop('checked',true);
    }else{
        list.find('.checklist-check').prop('checked',false);
    }
});

// checklist check change
$(document).on('change','.checklist-check',function (){
    let list = $(this).parents('.checklist-list');
    let checkAllCheck = list.find('.checklist-check-all');
    let allCheckboxes = list.find('.checklist-check');
    let allChecked = true;
    allCheckboxes.each(function (i,check){
        if (!$(check).is(":checked")){
            allChecked = false;
        }
    });
    if (allChecked){
        checkAllCheck.prop('checked',true);
    }else{
        checkAllCheck.prop('checked',false);
    }
});


function createNewMenuItem(menuId,title,link,btn,clearFields = false){
    let spinner = btn.find('.spinner-border');
    spinner.removeClass('d-none');
    btn.addClass('no-pointer-events');

    let data = new FormData();
    data.append('menu_id',menuId);
    data.append('title',title);
    data.append('link',link);

    $.ajax({
        method: 'POST',
        processData: false,
        contentType: false,
        url: '/admin/menu-items/create/',
        data: data,
        headers: {'X-CSRF-TOKEN': _token},
        error:function (e) {
            spinner.addClass('d-none');
            btn.removeClass('no-pointer-events');
        }
    }).done(function (data) {
        if (data['status'] === 'success'){
            Toast.fire({
                icon: 'success',
                position: 'bottom-right',
                text: "آیتم جدید با موفقیت اضافه شد."
            });

            // clear form
            if(clearFields){
                $('.custom-item-form').find('.form-control').val('').removeClass('is-invalid');
            }

            // add item to list
            addMenuItemToList(data['item']);

            $('.bulk-selection').removeClass('d-none');

        }else{
            Toast.fire({
                icon: 'error',
                position: 'bottom-right',
                text: "مشکلی پیش آمد، عملیات انجام نشد!"
            })
        }

    }).always(function () {
        spinner.addClass('d-none');
        btn.removeClass('no-pointer-events');
    });
}

function addMenuItemToList(item){
    let el = "<div class='accordion-item-container' data-depth='0'>" +
        "<div class='accordion-item menu-item-accordion card mb-2' data-menu-item-id='"+item['id']+"' data-menu-item-parent='0' id='accordion-"+item['id']+"'>\n" +
        "    <input type='hidden' class='item-index-input' name='item_"+item['id']+"' value='"+item['order']+"_"+item['parent_id']+"'>\n" +
        "    <div class='accordion-header d-flex align-items-center'>\n" +
        "       <div class='form-check me-2 d-none'>\n" +
        "            <input class='form-check-input item-delete-check' type='checkbox' id='delete-check-"+item['id']+"' data-item-id='"+item['id']+"' data-item-title='"+item['title']+"'>\n" +
        "       </div>" +
        "        <button type='button' class='accordion-button collapsed' data-bs-toggle='collapse'\n" +
        "                data-bs-target='#item-"+item['id']+"' aria-expanded='false'>\n" +
        "            <div class='spinner-border spinner-border-sm text-secondary me-2 d-none' role='status'>\n" +
        "                <span class='visually-hidden'>در حال بارگذاری ...</span>\n" +
        "            </div>\n" +
        "            <i class='bx bx-move me-2'></i>\n" +
        "            <span class='title'>"+item['title']+"</span>\n" +
        "        </button>\n" +
        "    </div>\n" +
        "    <div id='item-"+item['id']+"' class='accordion-collapse collapse' data-bs-parent='#accordionItems'>\n" +
        "        <div class='accordion-body p-3 menu-item-form' data-id='"+item['id']+"'>\n" +
        "            <div class='mb-3'>\n" +
        "                <label for='"+item['id']+"-title' class='form-label'>عنوان</label>\n" +
        "                <input type='text' class='form-control form-control-sm title-field' id='"+item['id']+"-title' value='"+item['title']+"'>\n" +
        "                <span class='invalid-feedback'>وارد کردن این فیلد الزامی است.</span>\n" +
        "            </div>\n" +
        "            <div class='mb-3'>\n" +
        "                <label for='"+item['id']+"-link' class='form-label'>لینک</label>\n" +
        "                <input type='text' class='form-control form-control-sm link-field' dir='ltr' id='"+item['id']+"-link' value='"+item['link']+"'>\n" +
        "                <span class='invalid-feedback'>وارد کردن این فیلد الزامی است.</span>\n" +
        "            </div>\n" +
        "            <div class='d-flex align-items-center'>\n" +
        "                <button type='button' class='btn btn-sm btn-primary btn-menu-item-save'>\n" +
        "                    <div class='spinner-border spinner-border-sm text-white d-none' role='status'>\n" +
        "                        <span class='visually-hidden'>در حال بارگذاری ...</span>\n" +
        "                    </div>\n" +
        "                    <span>ذخیره</span>\n" +
        "                </button>\n" +
        "                <button type='button' class='btn btn-sm btn-label-secondary btn-menu-item-cancel ms-2' data-bs-toggle='collapse' data-bs-target='#item-"+item['id']+"'>انصراف</button>\n" +
        "                <button type='button' class='btn btn-sm btn-danger btn-menu-item-delete ms-auto'><i class='bx bx-trash-alt'></i></button>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "    </div>\n" +
        "<div class='nested-scrollable ps-5 mb-2' data-depth='1'></div> " +
        "</div>";

    $('#noItemsMsg').remove();
    $('#accordionItems').append(el);

    let nestedSortables = $('.nested-scrollable');
    for (var i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], nestedSortableOptions);
    }

}

function reorderMenuItem(){
    let container = $('#accordionItems');
    let items = container.find('.menu-item-accordion');
    let data = new FormData();

    items.each(function (i, el){
       let input = $(el).find('.item-index-input');
        data.append(input.attr('name'),input.val());
    });
    container.addClass('is-loading');

    $.ajax({
        method: 'POST',
        processData: false,
        contentType: false,
        url: '/admin/menus/ajax-items-update/',
        data: data,
        headers: {'X-CSRF-TOKEN': _token},
        error:function (e) {
            console.log(e);
            container.removeClass('is-loading');
        }
    }).done(function (data) {

    }).always(function () {
        container.removeClass('is-loading');
    });

}
