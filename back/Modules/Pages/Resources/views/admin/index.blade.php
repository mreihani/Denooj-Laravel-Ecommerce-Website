@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">برگه ها /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('pages.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('pages.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('pages.trash')}}" class="btn btn-label-secondary"><span><i class="bx bx-trash me-sm-2"></i> <span class="d-none d-sm-inline-block">زباله‌دان</span></span></a>
                <a href="{{route('pages.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></a>
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($pages->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>نامک</th>
                        <th>وضعیت</th>
                        <th>تعداد بازدید</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($pages as $page)
                        <tr>
                            <td>
                                <a href="{{$page->getImage()}}" target="_blank">
                                    <img src="{{$page->getImage('thumb')}}" alt="image" class="rounded" style="width: 80px;">
                                </a>
                            </td>
                            <td>{{$page->title}}</td>
                            <td>{{$page->slug}}</td>
                            <td>
                                @switch($page->status)
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

                            <td>{{views($page)->count()}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('page.show',$page)}}"><i class="bx bx-show me-1"></i> مشاهده</a>
                                        <a class="dropdown-item" href="{{route('pages.edit',$page)}}"><i class="bx bx-edit-alt me-1"></i> ویرایش</a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);" data-alert-message="بعد از حذف به سطل زباله منتقل میشود."><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('pages.destroy',$page)}}" method="post" class="d-inline-block">
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

            {{$pages->links()}}

        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
