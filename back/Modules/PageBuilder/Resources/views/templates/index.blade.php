@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">قالب ها /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('templates.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('templates.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('templates.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></a>
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($templates->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>نوع</th>
                        <th>آخرین ویرایش</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($templates as $template)
                        <tr>
                            <td>
                                {{$template->title}}

                                @if($template->id == $appearanceSettings->home_template)
                                    <b class="ms-1 text-primary">(قالب صفحه اصلی)</b>
                                @endif
                            </td>
                            <td>{{$template->type}}</td>
                            <td><span class="font-13">{{verta($template->updated_at)->format('%Y/%m/%d در ساعت H:i')}}</span></td>
                            <td>

                                <a href="{{route('template.preview',$template)}}" class="btn btn-dark ms-auto" target="_blank">
                                    <i class="bx bx-show me-2"></i><span>پیشنمایش</span></a>

                                <a href="{{route('templates.edit',$template)}}" class="btn btn-label-primary ms-auto">
                                    <i class="bx bx-edit-alt me-2"></i><span>ویرایش</span></a>

                                <form action="{{route('templates.destroy',$template)}}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="delete-row btn-fore-delete btn btn-label-danger">
                                        <i class="bx bx-trash me-2"></i><span>حذف</span>
                                    </button>
                                </form>


                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$templates->links()}}

        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
