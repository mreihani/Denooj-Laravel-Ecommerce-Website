<article class="post-item">
    <div class="post-thumb">
        <span class="post-thumb-icon"><i class="icon-eye"></i></span>
        <a href="{{route('post.show',$post)}}" title="{{$post->title}}">
            <img src="{{$post->getImage('medium')}}" alt="{{$post->image_alt}}">
        </a>
    </div>
    <div class="post-entry">
        <div class="">
            @foreach($post->categories as $cat)
                <a href="{{route('post_category.show',$cat)}}" class="post-cat">{{$cat->title}}</a>
                @if(!$loop->last) ,@endif
            @endforeach
        </div>

        <a href="{{route('post.show',$post)}}"><h3 class="post-title">{{$post->title}}</h3></a>
            @if(!isset($hideExcerpt))
            <div class="post-excerpt-area">
                <p class="{{$post->excerpt ? 'post-excerpt': ''}}">{{$post->excerpt}}</p>
                <a href="{{route('post.show',$post)}}" class="read-more"><span>ادامه مطلب</span><i class="icon-chevron-left"></i></a>
            </div>
            @endif
        <div class="post-details">
            <div class="text-with-icon"><i class="icon-eye me-1"></i><span>{{views($post)->count() . ' بازدید'}}</span></div>
            <div class="text-with-icon ms-3"><i class="icon-calendar me-1"></i><span>{{verta($post->created_at)->format('%d %B، %Y')}}</span></div>
            <div class="text-with-icon ms-3"><i class="icon-clock me-1"></i><span>زمان مطالعه: {{$post->reading_time}}</span></div>
        </div>
    </div>
</article>
