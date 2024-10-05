let attributesSelect = $('#attributes');
let totalAttributesSelect = $('#total_attributes');

// total attr unselect
totalAttributesSelect.on('select2:unselect', function(e) {
    let values = e.params.data.id.split('-');
    let id = '#total_attr_' + values[1] + '_container';
    $(id).remove();
})

// attrs unselect
attributesSelect.on('select2:unselect', function(e) {
    let values = e.params.data.id.split('-');
    let id = '#attr_' + values[0] + '_container';
    $(id).remove();
})

// total attributes select
totalAttributesSelect.on('select2:select', function(e) {
    let label = e.params.data.text;
    let values = e.params.data.id.split('-');
    let name = values[1];
    let frontendType = values[2];
    let requiredAttr = '';
    let requiredName = values[3] === '1' ? '1' : '0';
    if (values[3] === '1') requiredAttr = 'required';
    let el = generateTotalAttributeField(label,frontendType,name,requiredName,requiredAttr);
    $('#totalAttributesContainer').append(el);
});

function generateTotalAttributeField(label,frontendType,name,requiredName,requiredAttr,val =''){
    let el = '';
    if (frontendType === 'text' || frontendType === 'number'){
        el = "<div class='mb-3' id='total_attr_"+name+"_container'>" +
            "<label class='form-label' for='total_attr_"+name+"'>"+ label +"</label>" +
            "<input type='"+frontendType+"' class='form-control' id='total_attr_"+name+"' " +
            "name='total_attr_"+name+"_"+frontendType+"_"+requiredName+"_"+label+"' "+requiredAttr+" value='"+val+"'>" +
            "</div>";
    }else if(frontendType === 'textarea'){
        el = "<div class='mb-3' id='total_attr_"+name+"_container'>" +
            "<label class='form-label' for='total_attr_"+name+"'>"+ label +"</label>" +
            "<textarea class='form-control' rows='2' id='total_attr_"+name+"' " +
            "name='total_attr_"+name+"_"+frontendType+"_"+requiredName+"_"+label+"' "+requiredAttr+">"+val+"</textarea>";
    }
    return el;
}

// attributes select
attributesSelect.on('select2:select', function(e) {
    let label = e.params.data.text;
    let values = e.params.data.id.split('-');
    let name = values[0];
    let frontendType = values[1];
    let el = '';
    let requiredAttr = '';
    let requiredName = values[3] === '1' ? '1' : '0';
    if (values[2] === '1') requiredAttr = 'required';
    if (frontendType === 'text' || frontendType === 'number'){
        el = "<div class='mb-3' id='attr_"+name+"_container'>" +
            "<label class='form-label' for='attr_"+name+"'>"+ label +"</label>" +
            "<input type='"+frontendType+"' class='form-control' id='attr_"+name+"' " +
            "name='attr_"+name+"_"+frontendType+"_"+requiredName+"_"+label+"' "+requiredAttr+">" +
            "</div>";
    }else if(frontendType === 'textarea'){
        el = "<div class='mb-3' id='attr_"+name+"_container'>" +
            "<label class='form-label' for='attr_"+name+"'>"+ label +"</label>" +
            "<textarea class='form-control' rows='2' id='attr_"+name+"' " +
            "name='attr_"+name+"_"+frontendType+"_"+requiredName+"_"+label+"' "+requiredAttr+"></textarea>";
    }
    $('#attributesContainer').append(el);
})


// delete image
$('.btn-delete-image').click(function () {
    let btn = $(this);
    let imagesInp = $('#old_images');
    let images = JSON.parse(imagesInp.val());
    let selectedImageInput = $('input#'+btn.attr('target-id'));
    let selectedImageContainer = selectedImageInput.parents('.pImage-container');
    let selectedImageJson = selectedImageInput.val();
    let selectedImageObj = JSON.parse(selectedImageJson);

    // remove item
    $(images).each(function (index,image) {
        if(image['original'] === selectedImageObj['original']){
            selectedImageContainer.remove();
            images.splice(index,1); // remove
        }
    });

    imagesInp.val(JSON.stringify(images));
});



$(document).on('change','#attribute_list',function (){
    let catId = $(this).val();
    let data = new FormData();
    data.append('category_id',catId);

    $.ajax({
        method: 'POST',
        processData: false,
        contentType: false,
        url: '/admin/get-cat-attributes/',
        data: data,
        headers: {'X-CSRF-TOKEN': _token},
        error:function (e) {
            console.log(e);
        }
    }).done(function (data) {

        if (data.length > 0){
            $('#totalAttributesContainer').html('');
            $('#total_attributes').val('');
        }
        $(data).each(function (index,item){
            let val = 'total-' + item['code'] + '-' + item['frontend_type'] + '-' + item['required'] + '-' + item['label'];
            let defaultValue = item['pivot']['default'];

            // select items
            let data = {
                id: val,
                text: item['label']
            };
            let newOption = new Option(data.text, data.id, true, true);
            $('#total_attributes').append(newOption).trigger('change');

            // generate fields
            let label = item['label'];
            let name = item['code'];
            let frontendType = item['frontend_type'] ;
            let requiredAttr = '';
            let requiredName = item['required'] === '1' ? '1' : '0';
            if (item['required'] === '1') requiredAttr = 'required';
            let el = generateTotalAttributeField(label,frontendType,name,requiredName,requiredAttr,defaultValue);
            $('#totalAttributesContainer').append(el);

        });

    }).always(function () {
    });
});

