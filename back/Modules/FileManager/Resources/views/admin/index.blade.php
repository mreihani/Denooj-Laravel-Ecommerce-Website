@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">فایل ها /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('files.search')}}">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('files.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('files.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-upload me-sm-2"></i> <span class="d-none d-sm-inline-block">آپلود فایل جدید</span></span></a>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            @if($files->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>آیکن</th>
                        <th>نام</th>
                        <th>پسوند</th>
                        <th>سایز</th>
                        <th>لینک</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($files as $file)
                        <tr>
                            <td>
                                @if($file->isImage() && $file->image_thumb)
                                    <a href="{{'/storage' . $file->link}}" target="_blank">
                                        <img src="{{'/storage'.$file->image_thumb['thumb']}}" alt="image" class="rounded" style="width: 40px;">
                                    </a>
                                @else
                                <a href="{{$file->getIcon()}}" target="_blank">
                                    <img src="{{$file->getIcon()}}" alt="image" class="rounded" style="width: 40px;">
                                </a>
                                @endif
                            </td>
                            <td style="max-width: 150px;white-space: normal">{{$file->name}}</td>
                            <td>{{$file->extension}}</td>
                            <td style="direction: ltr">{{$file->humanFileSize()}}</td>
                            <td style="max-width: 600px;white-space: normal;">
                                <div class="d-flex flex-column justify-content-start align-items-start">
                                    @if($file->isImage())
                                        <a href="{{'/storage' . $file->link}}" class="btn btn-sm btn-label-primary mb-2" target="_blank">مشاهده تصویر</a>
                                    @endif
                                    <span style="direction: ltr">{{$file->getUrl()}}</span>

                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{'/storage' . $file->link}}" download="download" target="_blank"><i class="bx bx-download me-1"></i> دانلود</a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('files.destroy',$file)}}" method="post" class="d-inline-block">
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
            {{$files->links()}}
        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
