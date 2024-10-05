<div class="tab-pane fade" id="nav-questions" role="tabpanel" aria-labelledby="nav-questions-tab">
    <div class="d-flex align-items-center">
        <div class="font-20">
            <i class="icon-message-circle text-muted me-2"></i>
            <span class="d-inline-block fw-900 me-2">پرسش و پاسخ</span>
            <span class="d-inline-block fw-900 text-success">{{$questions->count()}}</span>
        </div>
        @auth
            <button type="button" class="btn btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#modalSubmitQuestion">ثبت پرسش</button>
        @else
            <a href="{{route('signin')}}" class="btn btn-outline-primary ms-3">ثبت پرسش</a>
        @endif
    </div>

    @if($product->questions->count() < 1)
        <div class="alert alert-warning mt-3">
            <i class="icon-alert-triangle me-2"></i><span>پرسشی برای این محصول ثبت نشده است.</span>
        </div>
    @else
        <div class="questions-container mb-5">
            @foreach($questions as $level1Question)
                @include('questions::question_item',$level1Question)
            @endforeach
        </div>
    @endif
</div>
