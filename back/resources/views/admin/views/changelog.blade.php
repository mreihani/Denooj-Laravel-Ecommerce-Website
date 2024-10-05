@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-0"><span class="text-muted fw-light">changelog | نسخه فعلی : {{config('changelog.current_version')}}</span></h4>

    <div class="accordion mt-3 accordion-header-primary" id="accordionStyle1">
        @php $index = 0; @endphp
        @foreach(config('changelog.changelogs') as $key => $log)
            @php $index++; @endphp
            <div class="accordion-item card">
            <h2 class="accordion-header">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-{{$index}}" aria-expanded="false">
                    {{'نسخه: ' . $key . ' ← ' . $log['date']}}
                </button>
            </h2>

            <div id="accordion-{{$index}}" class="accordion-collapse collapse" data-bs-parent="#accordionStyle1">
                <div class="accordion-body lh-2">
                    <ul class="list-group list-group-numbered">
                        @foreach($log['changes'] as $change)
                            <li class="list-group-item">{{$change}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>


@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
@endsection

