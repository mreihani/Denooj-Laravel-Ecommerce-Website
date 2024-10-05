<!-- Modal -->
<div class="modal fade" id="shareProductModal" tabindex="-1" aria-labelledby="shareProductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اشتراک‌گذاری</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">این کالا را با دوستان خود به اشتراک بگذارید!</p>

                <input class="opacity-0 h-0" id="inputToCopy" type="text" readonly value="{{route('product.show',$product)}}" aria-label="copy">
                <button class="btn btn-outline-dark w-100 mb-3 p-3 rounded-3" id="btnCopyLink">
                    <i class="icon-copy me-2"></i><span>کپی کردن لینک</span>
                </button>

                <form class="form-floating mb-3">
                    <input type="url" class="form-control" id="short_url" placeholder="{{route('product.short_url',$product->code)}}" value="{{route('product.short_url',$product->code)}}" readonly>
                    <label for="short_url">لینک کوتاه</label>
                </form>

                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <a href="https://api.whatsapp.com/send?text={{route('product.show',$product)}}" rel="nofollow" class="btn btn-dark btn-whatsapp w-100 p-3 rounded-3">
                            <i class="icon-whatsapp me-2"></i>
                            <span>واتساپ</span>
                        </a>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <a href="https://twitter.com/intent/tweet?url={{route('product.show',$product)}}&text={{route('product.show',$product)}}" rel="nofollow" class="btn btn-dark btn-twitter w-100 p-3 rounded-3">
                            <i class="icon-twitter me-2"></i>
                            <span>توییتر</span>
                        </a>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <a href="https://t.me/share/url?url={{rawurldecode(route('product.show',$product))}}" rel="nofollow" class="btn btn-dark btn-telegram w-100 p-3 rounded-3">
                            <i class="icon-telegram me-2"></i>
                            <span>تلگرام</span>
                        </a>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <a href="https://www.facebook.com/sharer.php?u={{route('product.show',$product)}}" rel="nofollow" class="btn btn-dark btn-facebook w-100 p-3 rounded-3">
                            <i class="icon-facebook me-2"></i>
                            <span>فیس بوک</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
