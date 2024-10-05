<a href="#" class="story-item" data-story-index="{{$index}}">
    <div class="story-item-circle {{isset($shape) && $shape == 'square' ? 'story-item-square' : ''}}">
        <img src="{{$story->getThumbnail()}}" alt="{{$story->title}}"/>

        @if(isset($shape) && $shape == 'square')
            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" style="enable-background:new -580 439 577.9 194;stroke: {{$strokeColor ?? ''}}" xml:space="preserve">
                <rect x="10" y="10" width="80" height="80" rx="10" ry="10"/>
            </svg>
        @else
            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                 style="enable-background:new -580 439 577.9 194;stroke: {{$strokeColor ?? ''}}" xml:space="preserve"><circle cx="50" cy="50" r="40"/></svg>
        @endif


    </div>

    @php $displayTitle = true;
        if(isset($showTitle) && !$showTitle){
            $displayTitle = false;
        }
    @endphp

    @if($displayTitle)
        <div class="story-item-title">{{$story->title}}</div>
    @endif

</a>
