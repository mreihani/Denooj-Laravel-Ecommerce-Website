@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">کاربران /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('users.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('users.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('users.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></a>
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($users->count() > 0)
                <table class="table table-striped" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>عملیات</th>
                        <th>تصویر</th>
                        <th>نام</th>
                        <th>نام خانوادگی</th>
                        <th>موبایل</th>
                        <th>کدملی</th>
                        <th>ایمیل</th>
                        <th>موجودی</th>
                        <th>سبد خرید</th>
                        <th>تاریخ ثبت نام</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('users.show',$user)}}"><i class="bx bx-show me-1"></i> مشاهده پروفایل</a>
                                        <a class="dropdown-item" href="{{route('users.edit',$user)}}"><i class="bx bx-edit-alt me-1"></i> ویرایش اطلاعات</a>
                                        <a class="dropdown-item" href="{{route('users.balance',$user)}}"><i class="bx bx-wallet me-1"></i> ویرایش موجودی</a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);" data-alert-message="تمامی اطلاعات مربوط به این کاربر هم حذف خواهد شد."><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('users.destroy',$user)}}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <span>حذف</span>
                                            </form>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{$user->getAvatar('original')}}" target="_blank">
                                    <img src="{{$user->getAvatar('thumb')}}" alt="{{$user->getFullName()}}" class="img-thumbnail" width="60">
                                </a>
                            </td>
                            <td>{{$user->first_name ?? '---'}}</td>
                            <td>{{$user->last_name ?? '---'}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->national_code ?? '---'}}</td>
                            <td>{{$user->email ?? '---'}}</td>
                            <td>{{number_format($user->wallet->balance) . ' تومان'}}</td>
                            <td style="max-width: 140px;white-space: normal">
                                @php $cart = \Cart::session($user->id); @endphp
                                @if($cart->getContent()->count() > 0)
                                    @foreach($cart->getContent() as $cartItem)
                                        <a href="{{route('product.show',$cartItem->associatedModel)}}" target="_blank" title="{{$cartItem->associatedModel->title}}">
                                            <img src="{{$cartItem->associatedModel->getImage('thumb')}}" alt="image" width="30">
                                        </a>
                                    @endforeach
                                @else
                                    <span>خالی</span>
                                @endif
                            </td>
                            <td>
                                @php $v = new \Verta($user->created_at) @endphp
                                {{$v->format('Y-n-j ساعت H:i')}}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$users->links()}}
        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
