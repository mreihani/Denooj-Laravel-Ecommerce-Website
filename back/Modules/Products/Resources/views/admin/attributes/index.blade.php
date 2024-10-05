@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">ویژگی های محصولات /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('attributes.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('attributes.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('attributes.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></a>
                <a href="{{route('attribute-categories.index')}}" class="dt-button create-new btn btn-dark"><span><i class="bx bx-list-ul me-sm-2"></i> <span class="d-none d-sm-inline-block">گروه ویژگی ها</span></span></a>
                <a href="{{route('attribute-values.index')}}" class="dt-button create-new btn btn-dark"><span><i class="bx bx-list-ul me-sm-2"></i> <span class="d-none d-sm-inline-block">مقادیر ویژگی ها</span></span></a>
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($attributes->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>نوع</th>
{{--                        <th>فیلتر شدنی</th>--}}
{{--                        <th>ضروری</th>--}}
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($attributes as $attr)
                        <tr>
                            <td>{{$attr->label}}</td>
                            <td>
                                @switch($attr->frontend_type)
                                    @case('text')
                                        متن (text)
                                        @break

                                    @case('textarea')
                                        متن چند خطی (textarea)
                                        @break

                                    @case('number')
                                        عدد (number)
                                        @break
                                @endswitch
                            </td>
{{--                            <td>--}}
{{--                                @if($attr->filterable )--}}
{{--                                    <span class="badge bg-label-primary">بله</span>--}}
{{--                                @else--}}
{{--                                    -----}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                @if($attr->required )--}}
{{--                                    <span class="badge bg-label-primary">بله</span>--}}
{{--                                @else--}}
{{--                                    -----}}
{{--                                @endif--}}
{{--                            </td>--}}
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('attributes.edit',$attr)}}"><i class="bx bx-edit-alt me-1"></i> ویرایش</a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('attributes.destroy',$attr)}}" method="post" class="d-inline-block">
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
            {{$attributes->links()}}

        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
