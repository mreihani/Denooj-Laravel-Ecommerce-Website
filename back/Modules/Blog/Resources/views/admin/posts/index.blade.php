@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مقالات /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('posts.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('posts.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('posts.trash')}}" class="btn btn-label-secondary"><span><i class="bx bx-trash me-sm-2"></i> <span class="d-none d-sm-inline-block">زباله‌دان</span></span></a>
                <a href="{{route('posts.create')}}" class="btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></a>
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($posts->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>نویسنده</th>
                        <th>وضعیت</th>
                        <th>دسته بندی</th>
                        <th>تعداد بازدید</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($posts as $post)
                        <tr>
                            <td>
                                <a href="{{$post->getImage()}}" target="_blank">
                                    <img src="{{$post->getImage('thumb')}}" alt="image" class="rounded" style="width: 80px;">
                                </a>
                            </td>
                            <td>
                                <p style="font-size: 14px;max-width: 100px;white-space: normal;">{{$post->title}}</p>

                            @if($post->featured)
                                    <span class="badge bg-label-warning"><i
                                            class="bx bxs-badge-check"></i> مقاله ویژه</span>
                                @endif
                            </td>
                            <td>{{$post->author->name}}</td>
                            <td>
                                @switch($post->status)
                                    @case('published')
                                        <span class="badge bg-label-success">منتشر شده</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-label-warning">در انتظار تایید</span>
                                        @break
                                    @case('draft')
                                        <span class="badge bg-label-secondary">پیش نویس</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($post->categories)
                                    @foreach($post->categories as $cat)
                                        <a href="{{route('post_category.show',$cat)}}" class="badge bg-label-primary">{{$cat->title}}</a>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{views($post)->count()}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('post.show',$post)}}"><i class="bx bx-show me-1"></i> مشاهده</a>
                                        <a class="dropdown-item" href="{{route('posts.edit',$post)}}"><i class="bx bx-edit-alt me-1"></i> ویرایش</a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);" data-alert-message="بعد از حذف به سطل زباله منتقل میشود."><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('posts.destroy',$post)}}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <span>حذف</span>
                                            </form>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$posts->links()}}

        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
