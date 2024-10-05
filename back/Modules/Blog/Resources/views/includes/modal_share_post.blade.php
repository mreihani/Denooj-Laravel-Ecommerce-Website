<!-- Modal -->
<div class="modal fade" id="sharePostModal" tabindex="-1" aria-labelledby="sharePostModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اشتراک‌گذاری</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">این مقاله را با دوستان خود به اشتراک بگذارید!</p>

                <input class="opacity-0 h-0" id="inputToCopy" type="text" readonly value="{{route('post.show',$post)}}" aria-label="copy">
                <button class="btn btn-outline-dark w-100 mb-3 p-3 rounded-3" id="btnCopyLink">
                    <i class="icon-copy me-2"></i><span>کپی کردن لینک</span>
                </button>

                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <a href="https://api.whatsapp.com/send?text={{route('post.show',$post)}}" rel="nofollow" class="btn btn-dark btn-whatsapp w-100 p-3 rounded-3">
                            <i class="icon-whatsapp me-2"></i>
                            <span>واتساپ</span>
                        </a>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <a href="https://twitter.com/intent/tweet?url={{route('post.show',$post)}}&text={{route('post.show',$post)}}" rel="nofollow" class="btn btn-dark btn-twitter w-100 p-3 rounded-3">
                            <i class="icon-twitter me-2"></i>
                            <span>توییتر</span>
                        </a>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <a href="https://t.me/share/url?url={{rawurldecode(route('post.show',$post))}}" rel="nofollow" class="btn btn-dark btn-telegram w-100 p-3 rounded-3">
                            <i class="icon-telegram me-2"></i>
                            <span>تلگرام</span>
                        </a>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <a href="https://www.facebook.com/sharer.php?u={{route('post.show',$post)}}" rel="nofollow" class="btn btn-dark btn-facebook w-100 p-3 rounded-3">
                            <i class="icon-facebook me-2"></i>
                            <span>فیس بوک</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
