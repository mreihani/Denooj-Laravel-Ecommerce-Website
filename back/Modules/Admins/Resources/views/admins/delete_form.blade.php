@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('admins.index')}}">مدیرها</a> /</span> حذف مدیر
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('admins.destroy',$admin)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-6">
            <div class="card mb-4">

                <div class="card-body">
                    <form action="{{route('admins.destroy',$admin)}}" method="post" class="row">
                        @csrf
                        @method('DELETE')

                        <div class="col-lg-12">
                            <h5 class="mb-3 font-18">شما درحال حذف حساب کاربری مدیر ({{$admin->name . ' - ' . $admin->email}}) هستید.</h5>

                            <p>تصمیم دارید با اطلاعات این مدیر از جمله، محصولات و مقالات چه کاری انجام دهید؟</p>

                            <select name="result" id="result" aria-label="result" class="form-select">
                                <option value="to_me" selected>تخصیص همه اطلاعات به حساب کاربری من ({{auth()->guard('admin')->user()->name . ' - ' . auth()->guard('admin')->user()->email}})</option>
                                <option value="delete">حذف همه اطلاعات برای همیشه</option>
                            </select>
                        </div>


                        {{-- submit--}}
                        <div class="col-lg-6">
                            <div class="mb-3 mt-4">
                                <span type="button" class="btn btn-primary submit-button" id="deleteBtn">حذف حساب کاربری</span>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </form>


@endsection

@section('styles')
@endsection
@section('scripts')
    <script>
        // table item delete button click
        $(document).on('click','#deleteBtn',function (){
            let button = $(this);
            Swal.fire({
                title: 'آیا از حذف مطمئن هستید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'بله، حذف کن!',
                cancelButtonText: 'انصراف',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $('#mainForm').submit();
                }
            });
        })

    </script>
@endsection
