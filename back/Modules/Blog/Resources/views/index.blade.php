@extends('front.layouts.master',
['h1Title' => isset($category) ? $category->h1_hidden : (isset($tag) ? $tag->name : 'وبلاگ'),
'navTitle' => isset($category) ? $category->nav_title : (isset($tag) ? $tag->nav_title : 'وبلاگ')
,'robots' => 'index'])
@section('content')
    <div class="container-fluid page-content">
        <div class="archive-head mb-4">
            <div class="custom-container d-flex flex-column flex-lg-row align-items-center justify-content-between">
                <h2 class="archive-title">{{$title}}</h2>

                {{-- breadcrumb --}}
                <nav aria-label="breadcrumb" class="breadcrumb-container">
                    <ol class="breadcrumb d-flex justify-content-center align-items-center w-100 mt-3 mt-lg-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{config('app.app_name_fa')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="custom-container">
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-lg-4 col-sm-6 mb-4">
                        @include('blog::includes.post_item',$post)
                    </div>
                @endforeach
                <div class="col-12 mt-4">
                    {{$posts->links('front.vendor.pagination.bootstrap-4')}}
                </div>
            </div>
        </div>

        {{-- seo description --}}
        @if((isset($category) && $category->seo_description != null) || (isset($tag) && $tag->seo_description != null))
            <div class="custom-container mt-5">
                <section class="section">
                    <div class="row">
                        <div class="col-12">
                            <div class="box content-area shadow-none content-dropdown">

                                @if(isset($category))
                                    {!! $category->seo_description !!}
                                @elseif(isset($tag))
                                    {!! $tag->seo_description !!}
                                @endif
                                <button type="button" class="content-dropdown-toggle"><span>مشاهده بیشتر</span><i
                                        class="icon-chevron-down ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @endif

    </div>
@endsection
@section('scripts')
@endsection
