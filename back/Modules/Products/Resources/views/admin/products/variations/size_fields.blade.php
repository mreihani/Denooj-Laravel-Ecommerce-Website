<div class="row align-items-end">

    @php
        $fieldPrefix = 'size_' . $sizeModel->name;
        $toggleId = $sizeModel->name;
        if (isset($colorModel)){
            $toggleId.= '_' . $colorModel->name;
            $fieldPrefix = 'colorsize_' . $sizeModel->name . '|' . $colorModel->name;
        }
@endphp

    {{-- price --}}
    <div class="mb-3 col-lg-6">
        <label class="form-label" for="{{$fieldPrefix}}_price">قیمت
            (ضروری)</label>
        <div class="input-group">
            <input type="number" class="form-control"
                   id="{{$fieldPrefix}}_price"
                   name="{{$fieldPrefix.'|_price'}}" value="{{old($fieldPrefix.'|_price',$inventory->price)}}"
                   required>
            <span class="input-group-text">تومان</span>
        </div>
    </div>

    {{-- sale price --}}
    <div class="mb-3 col-lg-6">
        <label class="form-label" for="{{$fieldPrefix}}_saleprice">قیمت فروش
            ویژه
            (اختیاری)</label>
        <div class="input-group">
            <input type="number" class="form-control"
                   id="{{$fieldPrefix}}_saleprice" name="{{$fieldPrefix.'|_saleprice'}}"
                   value="{{old($fieldPrefix.'|_saleprice',$inventory->sale_price)}}">
            <span class="input-group-text">تومان</span>
        </div>
    </div>

    {{-- manage stock --}}
    <div class="mb-3 col-lg-6">
        <div class="form-check form-switch">
            <input class="form-check-input check-toggle"
                   type="checkbox"
                   data-toggle="#stockContainer{{$toggleId}}"
                   data-toggle-reverse="#stockStatusContainer{{$toggleId}}"
                   id="{{$fieldPrefix.'_managestock'}}"
                   name="{{$fieldPrefix.'|_managestock'}}" {{$inventory->manage_stock ? 'checked' :''}}>
            <label class="form-check-label"
                   for="{{$fieldPrefix.'_managestock'}}">مدیریت
                موجودی</label>
        </div>
    </div>

    {{-- stock --}}
    <div id="stockContainer{{$toggleId}}"
         class="mb-3 col-lg-6 {{$inventory->manage_stock ? '' :'d-none'}}">
        <label class="form-label" for="{{$fieldPrefix.'_stock'}}">موجودی</label>
        <input type="number" class="form-control" id="{{$fieldPrefix.$sizeModel->name.'_stock'}}"
               name="{{$fieldPrefix.'|_stock'}}" value="{{old($fieldPrefix.'|_stock',$inventory->stock)}}">
    </div>

    {{-- stock_status --}}
    <div
        class="mb-3 col-lg-6 {{$inventory->manage_stock ? 'd-none' :''}}"
        id="stockStatusContainer{{$toggleId}}">
        <label class="form-label" for="{{$fieldPrefix.'_stockstatus'}}">وضعیت
            موجودی</label>
        <select class="form-select" name="{{$fieldPrefix.'|_stockstatus'}}" id="{{$fieldPrefix.'_stockstatus'}}">
            <option value="in_stock" {{$inventory->stock_status == 'in_stock' ? 'selected' : ''}}>موجود در انبار</option>
            <option value="out_of_stock" {{$inventory->stock_status == 'out_of_stock' ? 'selected' : ''}}>ناموجود</option>
        </select>
    </div>
</div>
