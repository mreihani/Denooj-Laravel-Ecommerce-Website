@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تیکت ها /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('tickets.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('tickets.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($tickets->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>َشماره تیکت</th>
                        <th>عنوان</th>
                        <th>وضعیت</th>
                        <th>کاربر</th>
                        <th>تعداد پاسخ ها</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{$ticket->code}}</td>
                            <td>{{$ticket->title}}</td>
                            <td>
                                @switch($ticket->status)
                                    @case('pending') <span class="badge bg-label-warning">در انتظار بررسی</span> @break
                                    @case('user_response') <span class="badge bg-label-danger">پاسخ کاربر</span> @break
                                    @case('support_response') <span class="badge bg-dark">پاسخ پشتیبانی</span> @break
                                    @case('close') <span class="badge bg-secondary">بسته شده</span> @break
                                @endswitch
                            </td>
                            <td><a href="{{route('users.show',$ticket->user)}}">{{$ticket->user->getFullName()}}</a></td>
                            <td>{{$ticket->responses->count()}}</td>
                            <td>
                                @php $v = new \Verta($ticket->created_at) @endphp
                                {{$v->format('Y-n-j | H:i')}}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 px-2 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('tickets.edit',$ticket)}}"><i class="bx bx-edit-alt me-1"></i> مشاهده / ویرایش</a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('tickets.destroy',$ticket)}}" method="post" class="d-inline-block">
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
            {{$tickets->links()}}
        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
