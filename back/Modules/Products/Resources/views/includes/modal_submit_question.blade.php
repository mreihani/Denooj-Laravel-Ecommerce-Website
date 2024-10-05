<div class="modal fade" id="modalSubmitQuestion" data-bs-backdrop="static"
     data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalSubmitQuestion" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title font-16 fw-bold" id="staticBackdropLabel">پرسش خود را در مورد محصول مطرح کنید</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('submit_question',$product)}}" method="post" id="questionForm">
                    @csrf
                    <input type="hidden" id="response_to" name="parent_id">
                    <textarea name="text" id="question-text" cols="4" rows="4" aria-label="text"
                              class="form-control flat-input" placeholder="لطفا پرسش خود را بنویسید (حداقل 3 کلمه)"></textarea>

                    <div class="w-100 d-flex justify-content-between custom-border-t">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="alarm_me" name="alarm">
                            <label class="form-check-label" for="alarm_me">
                                اگر پاسخ داده شد خبر بده
                            </label>
                        </div>
                        <button type="button" class="btn btn-primary submit-button" id="submitQuestionBtn">ثبت پرسش</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
