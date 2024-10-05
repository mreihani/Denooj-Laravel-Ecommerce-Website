<article class="post-item-h">
    <div class="post-thumb">
        <a href="{{route('post.show',$post)}}" title="{{$post->title}}">
            <img src="{{$post->getImage('thumb')}}" alt="{{$post->image_alt}}">
        </a>
    </div>
    <div class="post-entry">
        <a href="{{route('post.show',$post)}}"><h3 class="post-title">{{$post->title}}</h3></a>
        <div class="text-with-icon text-muted font-13"><i class="icon-calendar me-1"></i><span>{{verta($post->created_at)->format('%d %B، %Y')}}</span></div>
    </div>
</article>
