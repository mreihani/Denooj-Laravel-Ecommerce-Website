<div class="box mt-4" id="tabs">
    <nav>
        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-intro-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-intro" type="button" role="tab" aria-controls="nav-intro" aria-selected="true">
                <i class="icon-book-open"></i>
                <span>معرفی محصول</span>
            </button>
            @if($product->total_attributes != null && count($product->total_attributes) > 0)
                <button class="nav-link" id="nav-attributes-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-attributes" type="button" role="tab" aria-controls="nav-attributes" aria-selected="false">
                    <i class="icon-grid"></i>
                    <span>مشخصات کلی</span>
                </button>
            @endif
            @if(\Nwidart\Modules\Facades\Module::has('Comments') && \Nwidart\Modules\Facades\Module::isEnabled('Comments') && $product->display_comments)
            <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-reviews" type="button" role="tab" aria-controls="nav-reviews" aria-selected="false">
                <i class="icon-message-circle"></i>
                <span>دیدگاه‌ها</span>
            </button>
            @endif
            @if(\Nwidart\Modules\Facades\Module::has('Questions') && \Nwidart\Modules\Facades\Module::isEnabled('Questions') && $product->display_questions)
            <button class="nav-link" id="nav-questions-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-questions" type="button" role="tab" aria-controls="nav-questions" aria-selected="false">
                <i class="icon-info"></i>
                <span>پرسش و پاسخ</span>
            </button>
            @endif

        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active content-body" id="nav-intro" role="tabpanel" aria-labelledby="nav-intro-tab">
            {!! $product->body !!}
        </div>
        @if($product->total_attributes != null && count($product->total_attributes) > 0)
            @include('products::includes.tabs.attributes-tab-content',$product)
        @endif

        @if(\Nwidart\Modules\Facades\Module::has('Comments') && \Nwidart\Modules\Facades\Module::isEnabled('Comments'))
        @include('products::includes.tabs.reviews-tab-content',$product)
        @endif

        @if(\Nwidart\Modules\Facades\Module::has('Questions') && \Nwidart\Modules\Facades\Module::isEnabled('Questions'))
        @include('products::includes.tabs.question-tab-content',$product)
        @endif

    </div>
</div>
