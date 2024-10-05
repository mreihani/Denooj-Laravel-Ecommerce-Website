<nav aria-label="breadcrumb" class="breadcrumb-container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{config('app.app_name_fa')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('post_category.show',$post->getMainCategory())}}">{{$post->getMainCategory()->title}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$post->title}}</li>
    </ol>
</nav>
