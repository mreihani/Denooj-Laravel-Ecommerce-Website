<div class="d-flex flex-column border p-3 rounded mb-3">
    <div class="d-flex align-items-center {{!$comment->product ? 'justify-content-between' : ''}} mb-4">
        @if($comment->product)
        <span class="badge me-3 {{$comment->score > 3 ? 'bg-success' : ($comment->score == 3 ? 'bg-warning' : 'bg-danger')}}">{{str_pad($comment->score, 3, '.0')}}</span>
        @endif
            <span class=" font-13 text-muted">{{$comment->anonymous ? 'کاربر ناشناس' : $comment->getSenderName()}}</span>
            <span class="{{$comment->product ? 'inline-list-item' : ''}} text-muted font-13">{{verta($comment->created_at)->format('%d %B، %Y')}}</span>
        @if($comment->from_buyer)
            <span class="badge bg-gray font-13 ms-2 fw-normal">خریدار</span>
        @endif
    </div>
    <p class="font-15 {{$comment->post ? 'mb-0' : ''}}">{{$comment->comment}}</p>
    @if($comment->strengths != null)
        @foreach($comment->strengths as $strength)
            <div class="mb-1 font-12"><i class="icon-plus text-success me-1"></i><span>{{$strength}}</span></div>
        @endforeach
    @endif

    @if($comment->weaknesses != null)
        @foreach($comment->weaknesses as $weakness)
            <div class="mb-1 font-12"><i class="icon-minus text-danger me-1"></i><span>{{$weakness}}</span></div>
        @endforeach
    @endif
</div>
