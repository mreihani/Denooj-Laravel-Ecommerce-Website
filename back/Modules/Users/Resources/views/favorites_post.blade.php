@extends('front.layouts.user_panel')
@section('panel_content')
    <div class="section-title font-18 fw-bold">مقالات نشان‌شده</div>
    <div class="row mt-4">
        @foreach($posts as $post)
            <div class="col-md-4">
                @include('blog::includes.post_item',['post' => $post,'hideExcerpt' => true])
            </div>
        @endforeach

        <div class="col-12 mt-3">
            {{$posts->links('front.vendor.pagination.bootstrap-4')}}
        </div>
    </div>
@endsection
