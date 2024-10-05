<section class="section">
    <div class="{{$row->layout == 'box' ? 'custom-container' : ''}}">
        <div class="box content-area shadow-none">
            <span class="d-block mb-4 fw-800 font-22">{{$row->featured_products_title}}</span>

            @if($row->faq != null && count($row->faq) > 0)
                <div class="accordion" id="accordionFaq{{$row->id}}">
                    @foreach($row->faq  as $key => $faqItem)
                        <div class="accordion-item">
                            <h4 class="accordion-header m-0" id="heading-{{$key}}">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{$key}}" aria-expanded="false"
                                        aria-controls="collapse-{{$key}}">
                                    {{$faqItem[0]}}
                                </button>
                            </h4>
                            <div id="collapse-{{$key}}" class="accordion-collapse collapse"
                                 aria-labelledby="collapse-{{$key}}" data-bs-parent="#accordionFaq{{$row->id}}">
                                <p class="accordion-body m-0">{{$faqItem[1]}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</section>



