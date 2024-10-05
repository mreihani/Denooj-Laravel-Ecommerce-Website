<a href="{{$banner->link}}" class="banner-item {{isset($class) ? $class : ''}}">
    <img src="{{$banner->getImage('original')}}" alt="{{$banner->title}}">
</a>
