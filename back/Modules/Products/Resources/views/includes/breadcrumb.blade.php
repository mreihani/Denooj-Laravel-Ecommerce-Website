<nav aria-label="breadcrumb" class="breadcrumb-container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{config('app.app_name_fa')}}</a></li>
        @php $latestCat = $product->categories()->whereDoesntHave('subCategories')->first() @endphp
        @if(!$latestCat)
            @php $latestCat = $product->getMainCategory(); @endphp
        @endif
        @if($latestCat)
            @if($latestCat->parent)
                @if($latestCat->parent->parent)
                    @if($latestCat->parent->parent->parent)
                        @if($latestCat->parent->parent->parent->parent)
                            <li class="breadcrumb-item"><a href="{{route('category.show',$latestCat->parent->parent->parent->parent)}}">{{$latestCat->parent->parent->parent->parent->title}}</a></li>
                        @endif
                        <li class="breadcrumb-item"><a href="{{route('category.show',$latestCat->parent->parent->parent)}}">{{$latestCat->parent->parent->parent->title}}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{route('category.show',$latestCat->parent->parent)}}">{{$latestCat->parent->parent->title}}</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{route('category.show',$latestCat->parent)}}">{{$latestCat->parent->title}}</a></li>
            @endif
            <li class="breadcrumb-item"><a href="{{route('category.show',$latestCat)}}">{{$latestCat->title}}</a></li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
    </ol>
</nav>
