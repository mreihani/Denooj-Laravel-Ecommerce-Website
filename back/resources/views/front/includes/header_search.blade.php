<div class="search-container">
    <input aria-label="search" type="text" id="{{$inputId}}" class="search-input" placeholder="{{$headerSettings->header_search_placeholder}}">
    <div class="search-action">
        <span class="search-spinner"><i class="icon-loader"></i></span>
        <span class="search-icon"><i class="icon-search"></i></span>
        <span class="search-clear d-none"><i class="icon-x"></i></span>
    </div>
    <div class="search-results">
        <div class="search-result-items"></div>
        <div class="search-recommendation">
            @if($headerSettings->search_recommendation != null)
            <span class="d-block mb-2">کلمات پیشنهادی:</span>
            @foreach($headerSettings->search_recommendation as $term)
            <span class="search-recommendation-item">{{$term}}</span>
            @endforeach
            @endif
        </div>
        <a href="#" class="search-more d-none" rel="nofollow" id="searchMoreLink"><i class="icon-plus"></i> نمایش نتایج بیشتر</a>
    </div>

</div>
