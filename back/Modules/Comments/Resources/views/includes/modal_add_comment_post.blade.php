<div class="modal fade" id="modalAddComment" data-bs-backdrop="static"
     data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddComment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content" id="commentForm">
            <input type="hidden" name="post_id" value="{{$post->id}}">
            <div class="modal-header">
                <div class="d-flex flex-column align-items-start">
                    <span class="modal-title font-16 fw-bold" id="staticBackdropLabel">دیدگاه شما</span>
                    <span class="font-12 text-muted d-block mt-2">{{$post->title}}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- comment --}}
                <textarea name="comment" id="question-text" cols="4" rows="4" aria-label="comment"
                          class="form-control flat-input" placeholder="متن دیدگاه خود را بنویسید..."></textarea>

                {{-- anonymous --}}
                <div class="w-100 d-flex justify-content-between custom-border-t">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="anonymous" name="anonymous">
                        <label class="form-check-label" for="anonymous">
                            ارسال به صورت ناشناس
                        </label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row w-100 align-items-center">
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-primary submit-button w-100" id="addCommentBtn">ثبت دیدگاه</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
