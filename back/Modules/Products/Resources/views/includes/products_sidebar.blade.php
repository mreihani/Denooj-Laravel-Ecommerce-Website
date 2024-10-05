<div class="box filters-sidebar">
    @php $requestUrl = rawurldecode(request()->getQueryString());@endphp

    <div class="mobile-section-head flex1200">
        <span class="font-18">فیلتر کردن محصولات</span>
        <span class="close" id="closeFilters"><i class="icon-x"></i></span>
    </div>

    {{-- remove all filters --}}
    <button type="button" id="btnRemoveAllFilters" class="btn btn-danger w-100 mb-3 {{empty($requestUrl) ? 'd-none' :''}}">
        <i class="icon-trash-2"></i>
        <span class="font-13">حذف فیلترهای اعمال شده</span>
    </button>

    {{-- price filter --}}
    <div class="filter-box mb-3 text-center pt-3">
        <span class="sidebar-section-title mb-4">محدوده قیمت</span>
        <input type="hidden" class="range-slider"/>
        <div class="price-range-labels">

            <div class="d-flex flex-column">
                <span>تا</span>
                <p id="range_max"></p>
                <span>تومان</span>
            </div>
            <div class="d-flex flex-column">
                <span>از</span>
                <p id="range_min"></p>
                <span>تومان</span>
            </div>
        </div>
        <span class="btn btn-dark btn-sm btn-block mt-3 disabled w-100" id="priceRangeBtn">اعمال فیلتر قیمت</span>
        <span class="btn btn-outline-danger btn-sm btn-block mt-2 w-100 d-none" id="priceRangeBtnClear"><i class="icon-x"></i> حذف فیلتر قیمت</span>
    </div>

    <div class="pjax-container">

        {{-- available check --}}
        <div class="check-row mb-3">
            <label class="switch">
                <input type="checkbox"
                       id="checkAvailable" {{strpos(request()->getRequestUri(),'filter[available]=true') ? 'checked':''}}>
                <span class="slider round"></span>
            </label>
            <label for="checkAvailable" class="title">فقط کالاهای موجود</label>
        </div>

        {{-- discounted check --}}
        <div class="check-row mb-3">
            <label class="switch">
                <input type="checkbox"
                       id="checkDiscounted" {{strpos(request()->getRequestUri(),'filter[hasDiscount]=true') ? 'checked':''}}>
                <span class="slider round"></span>
            </label>
            <label for="checkDiscounted" class="title">فقط تخفیف دار ها</label>
        </div>

        {{-- attribute filter --}}
        <div class="accordion" id="accordionFilters">
            @php $filterableAttributes = \Modules\Products\Entities\Attribute::where('filterable',true)->get();@endphp
            @foreach($filterableAttributes as $attribute)
                @php $hasAttribute = false;
                    if (str_contains($requestUrl,$attribute->code)){
                        $hasAttribute = true;
                    }
                @endphp

                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{$attribute->code}}">
                        <button class="accordion-button {{$hasAttribute ? 'changed' : ''}} collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$attribute->code}}"
                                aria-expanded="true" aria-controls="collapse{{$attribute->code}}">
                            <span class="sidebar-section-title font-14 m-0">فیلتر براساس {{$attribute->label}}</span>
                        </button>
                    </h2>
                    <div id="collapse{{$attribute->code}}" class="accordion-collapse collapse" aria-labelledby="heading{{$attribute->code}}" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
                            @foreach($attribute->values as $value)
                                @php $checked = false;
                                    if ($hasAttribute && str_contains($requestUrl,$value->value)){
                                        $checked = true;
                                    }
                                @endphp
                                <div class="form-check">
                                    <input class="form-check-input attribute-check" data-attribute-code="{{$attribute->code}}"
                                           type="checkbox" value="{{$value->value}}" id="{{'attr_'.$value->id}}"
                                        {{$checked ? 'checked':''}}>

                                    <label class="form-check-label" for="{{'attr_'.$value->id}}">
                                        {{$value->value}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- search in results --}}
        <div class="filter-box mb-3">
            <span class="sidebar-section-title mb-3">جستجو در نتایج</span>
            <div class="filter-search">
                <input aria-label="search" type="text" id="inpResultSearch" placeholder="کالای مورد نظر را جستجو کنید"
                       value="{{$searchQ ? $searchQ :''}}">
                <span class="btn no-transform {{$searchQ ? 'btn-danger':'btn-primary'}}"
                      id="{{$searchQ ? 'btnResultSearchClear':'btnResultSearch'}}">
                <i class="icon-{{$searchQ ? 'x':'search'}}"></i>
            </span>
            </div>
        </div>

        {{-- categories --}}
        @php $categories = \Modules\Products\Entities\Category::where('parent_id',null)->get() @endphp
        <ul class="filter-box filter-links mb-3">
            @foreach($categories as $category)
                <li><a href="{{route('category.show',$category)}}">{{$category->title}}</a>
                    @if($category->subCategories->count() > 0)
                        <ul>
                            @foreach($category->subCategories as $subcategory)
                                <li><a href="{{route('category.show',$subcategory)}}">{{$subcategory->title}}</a>
                                    @if($subcategory->subCategories->count() > 0)
                                        <ul>
                                            @foreach($subcategory->subCategories as $subsubcategory)
                                                <li>
                                                    <a href="{{route('category.show',$subsubcategory)}}">{{$subsubcategory->title}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>


</div>
