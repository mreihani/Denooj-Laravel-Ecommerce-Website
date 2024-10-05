<div class="modal fade" id="modalAddComment" data-bs-backdrop="static"
     data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddComment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" id="commentForm">
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="modal-header">
                <div class="d-flex flex-column align-items-start">
                    <span class="modal-title font-16 fw-bold" id="staticBackdropLabel">دیدگاه شما</span>
                    <span class="font-12 text-muted d-block mt-2">{{$product->title}}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">

                        {{-- score --}}
                        <div class="mb-3 text-center">
                            <label for="score" class="form-label fw-bold font-16"><i class="icon-star font-12 text-warning"></i> امتیاز دهید: <span id="selected_score"></span></label>
                            <input type="range" min="0" max="5" value="0" class="form-range" id="score">
                            <div class="score-range">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <span class="text-danger d-block mt-2 font-11 text-start" id="range_error"></span>
                        </div>

                        {{-- strengths --}}
                        <div class="mb-3">
                            <select name="strengths[]" id="strengths" aria-label="strengths" class="d-none" multiple></select>
                            <label for="strengths_repeater" class="form-label">نکات مثبت</label>
                            <div class="repeater-field" data-icon="icon-plus" data-icon-class="text-success" data-select-id="strengths">
                                <input type="text" class="form-control repeater-input" id="strengths_repeater">
                                <span class="repeater-field-add"><i class="icon-plus"></i></span>
                            </div>
                            <span class="text-danger d-block mt-2 font-11 error-msg"></span>
                        </div>

                        {{-- weaknesses --}}
                        <div class="mb-3">
                            <select name="weaknesses[]" id="weaknesses" aria-label="weaknesses" class="d-none" multiple></select>
                            <label for="weaknesses_repeater" class="form-label">نکات منفی</label>
                            <div class="repeater-field" data-icon="icon-minus" data-icon-class="text-danger" data-select-id="weaknesses">
                                <input type="text" class="form-control repeater-input" id="weaknesses_repeater">
                                <span class="repeater-field-add"><i class="icon-plus"></i></span>
                            </div>
                            <span class="text-danger d-block mt-2 font-11 error-msg"></span>
                        </div>

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
                    {{-- description --}}
                    <div class="col-lg-6">
                        <div class="content-body border rounded-3 p-3">
                            {!! $generalSettings->comment_text !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row w-100 align-items-center">
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-primary submit-button w-100" id="addCommentBtn">ثبت دیدگاه</button>
                    </div>
                    <div class="col-lg-6 text-center">
                        <p class="mb-0 font-13">ثبت دیدگاه به معنی موافقت با <a href="#">قوانین انتشار {{config('app.app_name_fa')}}</a> است.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
