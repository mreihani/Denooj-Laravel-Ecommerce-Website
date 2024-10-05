@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیرها /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('admins.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('admins.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('admins.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></a>
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($admins->count() > 0)
                <table class="table table-striped" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>عملیات</th>
                        <th>تصویر</th>
                        <th>نام</th>
                        <th>نقش</th>
                        <th>محتوا</th>
                        <th>ایمیل</th>
                        <th>تاریخ ثبت نام</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($admins as $admin)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('admins.edit',$admin)}}"><i class="bx bx-edit-alt me-1"></i> ویرایش اطلاعات</a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('admins.delete_form',$admin)}}" method="post" class="d-inline-block">
                                                @csrf
                                                <span>حذف</span>
                                            </form>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{$admin->getAvatar('original')}}" target="_blank">
                                    <img src="{{$admin->getAvatar('thumb')}}" alt="{{$admin->name}}" class="img-thumbnail" width="60">
                                </a>
                            </td>
                            <td>{{$admin->name}}</td>
                            <td>
                                @if($admin->roles)
                                    @foreach($admin->roles as $role)
                                        <span class="badge bg-label-primary">{{$role->label}}</span>
                                    @endforeach
                                @else
                                    ---
                                @endif
                            </td>
                            <td>
                                <span class="d-block mb-1 font-13">تعداد محصولات: {{$admin->products()->count()}}</span>
                                <span class="d-block mb-1 font-13">تعداد مقالات: {{$admin->posts()->count()}}</span>
                                <span class="d-block font-13">تعداد پاسخ ها: {{$admin->questions()->count()}}</span>
                            </td>
                            <td>{{$admin->email ?? '---'}}</td>
                            <td>
                                @php $v = new \Verta($admin->created_at) @endphp
                                {{$v->format('Y-n-j ساعت H:i')}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$admins->links()}}
        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
