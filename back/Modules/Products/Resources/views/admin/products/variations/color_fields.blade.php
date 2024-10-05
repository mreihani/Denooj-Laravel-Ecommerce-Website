<div class="row align-items-end">

    {{-- price --}}
    <div class="mb-3 col-lg-6">
        <label class="form-label" for="color_{{$colorModel->name}}_price">قیمت
            (ضروری)</label>
        <div class="input-group">
            <input type="number" class="form-control"
                   id="color_{{$colorModel->name}}_price"
                   name="{{'color_'.$colorModel->name.'|_price'}}" value="{{old('color_'.$colorModel->name.'|_price',$inventory->price)}}"
                   required>
            <span class="input-group-text">تومان</span>
        </div>
    </div>

    {{-- sale price --}}
    <div class="mb-3 col-lg-6">
        <label class="form-label" for="color_{{$colorModel->name}}_saleprice">قیمت فروش
            ویژه
            (اختیاری)</label>
        <div class="input-group">
            <input type="number" class="form-control"
                   id="color_{{$colorModel->name}}_saleprice" name="{{'color_'.$colorModel->name.'|_saleprice'}}"
                   value="{{old('color_'.$colorModel->name.'|_saleprice',$inventory->sale_price)}}">
            <span class="input-group-text">تومان</span>
        </div>
    </div>

    {{-- manage stock --}}
    <div class="mb-3 col-lg-6">
        <div class="form-check form-switch">
            <input class="form-check-input check-toggle"
                   type="checkbox"
                   data-toggle="#stockContainer{{$colorModel->name}}"
                   data-toggle-reverse="#stockStatusContainer{{$colorModel->name}}"
                   id="{{'color_'.$colorModel->name.'_managestock'}}"
                   name="{{'color_'.$colorModel->name.'|_managestock'}}" {{$inventory->manage_stock ? 'checked' :''}}>
            <label class="form-check-label"
                   for="{{'color_'.$colorModel->name.'_managestock'}}">مدیریت
                موجودی</label>
        </div>
    </div>

    {{-- stock --}}
    <div id="stockContainer{{$colorModel->name}}"
         class="mb-3 col-lg-6 {{$inventory->manage_stock ? '' :'d-none'}}">
        <label class="form-label" for="{{'color_'.$colorModel->name.'_stock'}}">موجودی</label>
        <input type="number" class="form-control" id="{{'color_'.$colorModel->name.'_stock'}}"
               name="{{'color_'.$colorModel->name.'|_stock'}}" value="{{old('color_'.$colorModel->name.'|_stock',$inventory->stock)}}">
    </div>

    {{-- stock_status --}}
    <div
        class="mb-3 col-lg-6 {{$inventory->manage_stock ? 'd-none' :''}}"
        id="stockStatusContainer{{$colorModel->name}}">
        <label class="form-label" for="{{'color_'.$colorModel->name.'_stockstatus'}}">وضعیت
            موجودی</label>
        <select class="form-select" name="{{'color_'.$colorModel->name.'|_stockstatus'}}" id="{{'color_'.$colorModel->name.'_stockstatus'}}">
            <option value="in_stock" {{$inventory->stock_status == 'in_stock' ? 'selected' : ''}}>موجود در انبار</option>
            <option value="out_of_stock" {{$inventory->stock_status == 'out_of_stock' ? 'selected' : ''}}>ناموجود</option>
        </select>
    </div>
</div>
