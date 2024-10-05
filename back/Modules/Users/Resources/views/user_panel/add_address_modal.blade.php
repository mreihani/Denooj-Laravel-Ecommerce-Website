<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span class="form-title mb-0">افزودن آدرس جدید</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('address.create')}}" id="addressForm" method="post">
                    @csrf

                    <div class="row">

                        @if(empty(auth()->user()->first_name) || empty(auth()->user()->last_name))
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label" for="first_name">نام</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="نام خود را وارد نمایید">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label" for="last_name">نام خانوادگی</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="نام خانوادگی خود را وارد نمایید">
                                </div>
                            </div>
                        @endif

                        {{-- province --}}
                        <div class="col-lg-6 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="province">استان</label>
                                <select class="form-control select2" id="province" name="province">
                                    <option value="" selected>انتخاب استان</option>
                                    @foreach(\Modules\Users\Entities\Province::all() as $province)
                                        <option value="{{$province->id}}">{{$province->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        {{-- city --}}
                        <div class="col-lg-6 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="city">شهر</label>
                                <select class="form-control select2" id="city" name="city">
                                    <option value="" selected>انتخاب شهر</option>
                                </select>
                            </div>
                        </div>


                        {{-- post code --}}
                        <div class="col-lg-4 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="post_code">کد پستی</label>
                                <small class="d-block font-12 text-muted mt-0 mb-1">کد پستی را بدون خط فاصله
                                    بنویسید.</small>
                                <input type="text" class="form-control" id="post_code" name="post_code">
                            </div>
                        </div>


                        {{-- phone --}}
                        <div class="col-lg-4 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="phone">تلفن تماس</label>
                                <small class="d-block font-12 text-muted mt-0 mb-1">شماره موبایل یا تلفن ثابت با کد
                                    شهر.</small>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>

                        {{-- full name --}}
                        <div class="col-lg-4 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="full_name">نام تحویل گیرنده</label>
                                <small class="text-muted d-block font-12 mt-0 mb-1">نام و نام خانوادگی تحویل
                                    گیرنده</small>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                       value="{{old('full_name')}}">
                            </div>
                        </div>

                        {{-- address --}}
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="address">آدرس</label>
                                <small class="text-muted d-block font-12 mt-0 mb-1">لطفا آدرس را دقیق بنویسید شامل
                                    خیابان، کوچه، پلاک و جزئیات.</small>
                                <textarea id="address" name="address" type="text" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-center">
                                <button id="btnSubmit" class="btn btn-success shadow mb-3 px-4 font-15 form-submit"><i
                                            class="icon-check"></i> ثبت آدرس
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
