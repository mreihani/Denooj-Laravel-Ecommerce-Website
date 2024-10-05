@extends('front.layouts.master')
@section('content')
    @php $generalSettings = \Modules\Settings\Entities\GeneralSetting::firstOrCreate();@endphp
    <div class="container-fluid page-content mt-4">
        <div class="custom-container text-center">
            <h1 class="mt-4 font-28 text-center mb-5">{{$generalSettings->page_404_title}}</h1>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <img src="{{$generalSettings->get404Image()}}" alt="404 error" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection
