@php $comments = $product->comments()->where('status','published');@endphp
<div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
    <div class="row">
        {{-- detailds --}}
        <div class="col-lg-3 mb-4">
            <div class="comments-sidebar">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center font-15">
                        <span class="fw-900 font-30 lh-24 mt-2 mb-1 d-inline-block">{{$product->getAverageRating()}}</span>
                        از 5
                    </div>
                    <div class="d-flex flex-column align-items-start ms-3 ps-3 border-start">
                        <div class="d-flex stars-viewer dir-ltr">
                            <span class="{{round($product->getAverageRating()) == 5 ? 'active' : ''}}"></span>
                            <span class="{{round($product->getAverageRating()) == 4 ? 'active' : ''}}"></span>
                            <span class="{{round($product->getAverageRating()) == 3 ? 'active' : ''}}"></span>
                            <span class="{{round($product->getAverageRating()) == 2 ? 'active' : ''}}"></span>
                            <span class="{{round($product->getAverageRating()) == 1 ? 'active' : ''}}"></span>
                        </div>
                        <small class="text-muted mt-2">از مجموع {{$comments->count()}} نظر</small>
                    </div>
                </div>
                @auth
                <button class="btn btn-outline-primary w-100 mt-4" data-bs-toggle="modal" data-bs-target="#modalAddComment"><i class="icon-plus-circle me-3"></i><span>ثبت دیدگاه</span></button>
                @else
                <a href="{{route('signin')}}" class="btn btn-outline-primary w-100 mt-4"><i class="icon-plus-circle me-3"></i><span>ثبت دیدگاه</span></a>
                @endauth
            </div>
        </div>

        {{-- comments --}}
        <div class="col-lg-9">
            <div class="comments-container">
                @if($comments->count() > 0)
                    @foreach($comments->get() as $comment)
                        @include('comments::includes.comment_item',['comment' => $comment])
                    @endforeach
                @else
                    <p>هیچ دیدگاهی برای این محصول ثبت نشده است.</p>
                @endif
            </div>
        </div>
    </div>
</div>
