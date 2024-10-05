let templateId = $('#template_id').val();
$(function () {

    // update row




    // delete row
    $('.row-option-delete').click(function () {
        let btn = $(this);
        let rowId = $(this).attr('data-row-id');

        Swal.fire({
            title: 'از حذف سطر مطمئن هستید؟',
            text: 'این کار قابل بازگشت نیست!',
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
                let data = new FormData();
                data.append('id', rowId);

                $.ajax({
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    url: "/admin/templates/delete-row/",
                    data: data,
                    headers: {'X-CSRF-TOKEN': _token},
                    error: function (e) {
                        console.log(e);
                    }
                }).done(function (data) {

                    if (data) {
                        let row = btn.parent().parent('.accordion-item');
                        row.css('background','red');
                        row.find('.accordion-button').css('background','red');
                        row.slideUp('slow', function(){
                            row.remove();
                            resetItemOrders();
                        });

                    } else {
                        Toast.fire({
                            icon: 'error',
                            position: 'top-left',
                            text: "مشکلی پیش آمد، عملیات انجام نشد!"
                        })
                    }

                }).always(function () {
                });

            }
        });


    });


    // add new row
    $('.btn-add-new-row').click(function () {
        let btn = $(this);
        let widgetType = btn.attr('data-widget-type');
        let widgetName = btn.attr('data-widget-name');
        let widgetIcon = btn.attr('data-widget-icon');
        let data = new FormData();
        data.append('widget_type', widgetType);
        data.append('widget_name', widgetName);
        data.append('widget_icon', widgetIcon);
        data.append('template_id', templateId);

        btn.prop('disabled', true);
        btn.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span>');


        $.ajax({
            method: 'POST',
            processData: false,
            contentType: false,
            url: "/admin/templates/" + templateId + "/add-row/",
            data: data,
            headers: {'X-CSRF-TOKEN': _token},
        error: function (e) {
            console.log(e);
        }
    }).done(function (data) {
            if (data['success']) {
                window.location.reload();
            } else {

                Toast.fire({
                    icon: 'error',
                    position: 'bottom-left',
                    text: data['msg']
                })
            }

        }).always(function () {
            btn.prop('disabled', false);
            btn.html("<i class='bx bx-plus'></i>");
        });
    });



});


function resetItemOrders(){
    let accordionTemplate = document.getElementById('accordionTemplate');
    let dataArray = [];
    const items = accordionTemplate.querySelectorAll('.accordion-item');
    items.forEach((item, index) => {
        item.setAttribute('data-order', index + 1);

        let rowData = {
            'id': item.getAttribute('data-row-id'),
            'order': item.getAttribute('data-order'),
        }
        dataArray.push(rowData);
    });

    let data = new FormData();
    data.append('data', JSON.stringify(dataArray));
    $.ajax({
        method: 'POST',
        processData: false,
        contentType: false,
        url: "/admin/templates/update-row-index/",
        data: data,
        headers: {'X-CSRF-TOKEN': _token},
        error: function (e) {
            console.log(e);
        }
    }).done(function (data) {
        if (!data) {
            Toast.fire({
                icon: 'error',
                position: 'bottom-left',
                text: "مشکلی پیش آمد، تغییرات ذخیره نشد!"
            })
        }
    });
}

let sortableList;

// init drag and drop
(function () {
    let accordionTemplate = document.getElementById('accordionTemplate');
    if (accordionTemplate) {
        // level1 items
        sortableList = Sortable.create(accordionTemplate, {
            group: 'parent',
            animation: 150,
            handle: '.accordion-button',
            draggable: '.accordion-item',
            ghostClass: "sortable-ghost",  // Class name for the drop placeholder
            chosenClass: "sortable-chosen",  // Class name for the chosen item
            dragClass: "sortable-drag",  // Class name for the dragging item
            // onRemove: function (evt) {
            //     console.log('onRemove: ', evt);
            // },
            onEnd: function (evt) {
                resetItemOrders();
            },
        });
    }
})();
