
<!-- User Card -->
<div class="card mb-4">
    <div class="card-body">
        <div class="user-avatar-section">
            <div class="d-flex align-items-center flex-column">
                <img class="img-fluid rounded my-4" src="{{$user->getAvatar()}}" height="110" width="110" alt="User avatar">
                <div class="user-info text-center">
                    <h5 class="mb-2">{{$user->getFullName()}}</h5>
                    <span class="badge bg-label-secondary">عضویت در {{verta($user->created_at)->format('%d %B، %Y')}}</span>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start flex-wrap my-4 py-3">
            <div class="d-flex align-items-center me-4 mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded mt-1"><i class="bx bx-note bx-sm"></i></span>
                <div>
                    <h5 class="mb-0">{{$user->orders->count()}}</h5>
                    <span>سفارش ثبت شده</span>
                </div>
            </div>
            <div class="d-flex align-items-center mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded mt-1"><i class="bx bx-wallet bx-sm"></i></span>
                <div>
                    <h5 class="mb-0">{{number_format($user->wallet->balance) . ' تومان'}}</h5>
                    <span>اعتبار کیف پول</span>
                </div>
            </div>
        </div>
        @if(isset($simpleView))
            <div class="info-container">
                <a href="{{route('users.balance',$user)}}" class="btn btn-label-primary w-100 mb-2">افزایش / کسر از موجودی</a>
                <a href="{{route('users.show',$user)}}" class="btn btn-label-primary w-100">مشاهده پروفایل مشتری</a>
            </div>
        @else
        <div class="info-container">
            <ul class="list-unstyled">
                <li class="mb-3">
                    <span class="fw-bold me-2">کد ملی:</span>
                    <span>{{$user->national_code ?? '--'}}</span>
                </li>
                <li class="mb-3">
                    <span class="fw-bold me-2">ایمیل:</span>
                    <span>{{$user->email ?? '--'}}</span>
                </li>
                <li class="mb-3">
                    <span class="fw-bold me-2">موبایل:</span>
                    <span>{{$user->mobile}}</span>
                </li>
                <li class="mb-3">
                    <span class="fw-bold me-2">آخرین بروزرسانی:</span>
                    <span>{{verta($user->updated_at)->format('%d %B، %Y ساعت H:i')}}</span>
                </li>
            </ul>
            <div class="d-flex justify-content-center pt-3">
                <a href="{{route('users.edit',$user)}}" class="btn btn-primary me-3">ویرایش</a>
                <a href="#" class="btn btn-label-danger suspend-user">حذف کاربر</a>
            </div>
        </div>
        @endif
    </div>
</div>
