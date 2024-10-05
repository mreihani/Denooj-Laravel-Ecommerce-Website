{{-- level 1 --}}
<div class="question-item mt-5">
    @include('questions::question_item_content',['question' => $level1Question])
    <div class="question-item-footer">
        <a href="{{auth()->check() ? 'javascript:' : route('signin')}}" class="underline-link underline-link-main ms-auto @auth btn-question-response @endauth" data-response-id="{{$level1Question->id}}">پاسخ</a>
    </div>

    {{-- level 2 --}}
    @foreach($level1Question->responses as $level2Question)
        <div class="question-item">
            @include('questions::question_item_content',['question' => $level2Question])
            <div class="question-item-footer">
                <a href="{{auth()->check() ? 'javascript:' : route('signin')}}" class="underline-link underline-link-main ms-auto @auth btn-question-response @endauth" data-response-id="{{$level2Question->id}}">پاسخ</a>
            </div>

            {{-- level 3 --}}
            @foreach($level2Question->responses as $level3Question)
            <div class="question-item">
                @include('questions::question_item_content',['question' => $level3Question])
                <div class="question-item-footer">
                    <a href="{{auth()->check() ? 'javascript:' : route('signin')}}" class="underline-link underline-link-main ms-auto @auth btn-question-response @endauth" data-response-id="{{$level3Question->id}}">پاسخ</a>
                </div>

                {{-- level 4 --}}
                @foreach($level3Question->responses as $level4Question)
                    <div class="question-item">
                        @include('questions::question_item_content',['question' => $level4Question])

                        {{-- level 5 --}}
                        @foreach($level4Question->responses as $level5Question)
                            <div class="question-item">
                                @include('questions::question_item_content',['question' => $level5Question])
                            </div>
                        @endforeach
                    </div>
                @endforeach

            </div>
            @endforeach
        </div>
    @endforeach
</div>
