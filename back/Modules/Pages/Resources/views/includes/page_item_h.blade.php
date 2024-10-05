<article class="post-item-h">
    <div class="post-thumb">
        <a href="{{route('page.show',$page)}}" title="{{$page->title}}">
            <img src="{{$page->getImage('thumb')}}" alt="{{$page->image_alt}}" loading="lazy">
        </a>
    </div>
    <div class="post-entry">
        <a href="{{route('page.show',$page)}}"><h3 class="post-title">{{$page->title}}</h3></a>
        <div class="text-with-icon text-muted font-13"><i class="icon-calendar me-1"></i><span>{{verta($page->created_at)->format('%d %B، %Y')}}</span></div>
    </div>
</article>
