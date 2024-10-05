

// init sidebar products swiper
new Swiper('#recommendedProductsSwiper', {
    changeDirection: 'rtl',
    slidesPerView: 1,
    spaceBetween: 0,
    loop:true,
    autoplay:{
        delay:5000
    },
    navigation: {
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
    },
});

// add comment
$(document).on('click','#addCommentBtn',function (e){
    let btn = $(this);
    let container = $('#commentForm');
    let comment = container.find('textarea[name=comment]');
    let postId = container.find('input[name=post_id]').val();
    let anonymousCheck = $('#anonymous');
    let anonymous = !!anonymousCheck.is(":checked");

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
    data.append('post_id', postId);
    data.append('comment', comment.val());
    data.append('anonymous', anonymous);

    $.ajax({
        method: 'POST',
        url: '/panel/comment/post/add/',
        data: data,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': _token},
        error: function () {
            btn.removeClass('loading');
        }
    }).done(function (data) {
        console.log(data);
        if (data['status'] == 'success'){
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

