<div class="question-item-head">
    <img src="{{$question->getSenderAvatar()}}" alt="{{$question->getSenderName()}}">
    <div class="d-flex flex-column ms-3">
        <span class="mb-2 fw-bold">{{$question->getSenderName()}}</span>
        <span class="text-muted font-12">{{verta($question->created_at)->format('%d %B، %Y')}}</span>
    </div>
    @if($question->parent)
    <span class="question-item-response-to">{{'' . $question->getResponseToName()}}</span>
    @endif
    @if($question->isFromAdmin())
        <div class="question-item-badge"><i class="icon-check"></i> مدیر سایت</div>
    @endif
</div>
<p class="question-item-text">{{$question->text}}</p>
