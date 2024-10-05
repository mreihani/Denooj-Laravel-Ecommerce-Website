// open close sidebar
$(document).on('click','#openSidebar',function (){
    let toggle = $(this);
    let sidebar = $('#sidebar-box');
    let backdrop = $('.sidebar-backdrop');
    if (sidebar.hasClass('open')){
        sidebar.removeClass('open');
        toggle.removeClass('open');
        backdrop.hide();
    }else{
        sidebar.addClass('open');
        toggle.addClass('open');
        backdrop.fadeIn();
    }
});

// sidebar backdrop click
$(document).on('click','.sidebar-backdrop',function (){
    $(this).hide();
    $('#openSidebar').removeClass('open');
    $('#sidebar-box').removeClass('open');
    $('.sidebar-backdrop').removeClass('open');
});

function initCroppie(uploadUrl){
    console.log('init croppie!');
    $('.btnCroppieRemoveImage').on('click',function () {
        let container = $(this).parents('.user-image-upload');
        container.find('.croppie-input').val('');
        container.find('img').attr('src',$('#defaultImage').val());
        $(this).addClass('d-none');
    });

    let request;
    let preview = $('#preview').croppie({
        enableExif: true,
        enableOrientation: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            height: 400
        }
    });
    let cropBtn = $('#cropAndUpload');
    let fileInput = $('.upload_input');
    let container = null;
    let inpHidden = null;
    let modalEl = document.getElementById('imageUploadModal');


    let modal = new bootstrap.Modal(modalEl, {
        keyboard: false,
        backdrop: 'static'
    })

    fileInput.each(function () {
        $(this).change(function () {
            console.log('change');
            container = $(this).parents('.croppie-image');
            inpHidden = container.find('input[type=hidden]');

            let reader = new FileReader();
            reader.onload = function (event) {
                preview.croppie('bind', {
                    url: event.target.result
                });
            };
            reader.readAsDataURL(this.files[0]);
            modal.show();

            modalEl.addEventListener('hidden.bs.modal', function (event) {
                request.abort();
                fileInput.val('');
            })

        });
    });

    // upload image to server
    cropBtn.on('click', function () {
        cropBtn.addClass('loading');
        setTimeout(function () {
            preview.croppie('result', {
                type: 'blob',
                quality: 8,
                size: {width:400,height:400},
                format: 'png'
            }).then(function (blob) {
                let formData = new FormData();
                formData.append('image', blob);

                request = $.ajax({
                    type:'POST',
                    url: uploadUrl,
                    contentType: false,
                    processData: false,
                    data: formData,
                    headers: {'X-CSRF-TOKEN': _token},
                    error:function (e) {
                        console.log(e);
                        cropBtn.removeClass('loading');
                    }
                }).done(function (data) {
                    console.log(data);
                    let parsed = JSON.parse(data);

                    if (parsed['response'] === 'success') {
                        inpHidden.val(JSON.stringify(parsed['url']));
                        modal.hide();
                    } else {
                        console.log('something went wrong!');
                    }
                    cropBtn.removeClass('loading');
                    // display image
                    container.find('.square-image img').attr('src', '/storage' + parsed['url']['original']);
                    container.parents('.form-group').find('span.is-invalid').remove();
                }).always(function () {
                    cropBtn.removeClass('loading');
                });

            });
        }, 20);
    });


    $(document).on('click','#rotateImage',function (){
        preview.croppie('rotate',90);
    });
}

function deleteAddress(btn) {
    Swal.fire({
        text: "از حذف این آدرس مطمئن هستید؟",
        icon: 'warning',
        showCancelButton: true,
        focusCancel: true,
        confirmButtonText: 'بله حذف شود',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-danger me-3',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling:false
    }).then((result) => {
        if (result.value) {
            let delForm = $(btn).parent('form');
            delForm.submit();
        }
    });
}



$(document).ready(function () {
    // form validation
    $("#addressForm").validate({
        errorClass: "is-invalid",
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo( element.parent('.form-group') );
        },
        submitHandler: function(form) {
            $(form).find('#btnSubmit, .form-submit').addClass('loading');
            form.submit();
        },
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            province: {
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
            full_name: {
                required: true,
            }
        },
        messages: {
            first_name: {
                required: "نام خود را وارد کنید.",
            },
            last_name: {
                required: "نام خانوادگی خود را وارد کنید.",
            },
            province: {
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
            full_name: {
                required: "نام تحویل گیرنده را وارد کنید.",
            }
        }
    });
});
