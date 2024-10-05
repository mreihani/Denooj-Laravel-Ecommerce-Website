<div class="accordion-item menu-item-accordion card mb-2" data-menu-item-id="{{$item->id}}" data-menu-item-parent="{{$item->parent_id ?: '0'}}" id="{{'accordion-'.$item->id}}" >
    <input type="hidden" class="item-index-input" name="item_{{$item->id}}" value="{{$item->order. '_' . $item->parent_id}}">
    <div class="accordion-header d-flex align-items-center">
        <div class="form-check me-2 d-none">
            <input class="form-check-input item-delete-check" type="checkbox" id="{{'delete-check-' . $item->id}}" data-item-id="{{$item->id}}" data-item-title="{{$item->title}}">
        </div>
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                data-bs-target="{{'#item-' .$item->id}}" aria-expanded="false">
            <div class="spinner-border spinner-border-sm text-secondary me-2 d-none" role="status">
                <span class="visually-hidden">در حال بارگذاری ...</span>
            </div>
            <i class="bx bx-move me-2"></i>
            <span class="title">{{$item->title}}</span>
        </button>

    </div>
    <div id="{{'item-' .$item->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionItems">
        <div class="accordion-body p-3 menu-item-form" data-id="{{$item->id}}">
            <div class="mb-3">
                <label for="{{$item->id . '-title'}}" class="form-label">عنوان</label>
                <input type="text" class="form-control form-control-sm title-field" id="{{$item->id . '-title'}}" value="{{old($item->id . '-title',$item->title)}}">
                <span class="invalid-feedback">وارد کردن این فیلد الزامی است.</span>
            </div>
            <div class="mb-3">
                <label for="{{$item->id . '-link'}}" class="form-label">لینک</label>
                <input type="text" class="form-control form-control-sm link-field" dir="ltr" id="{{$item->id . '-link'}}" value="{{old($item->id . '-link',$item->link)}}">
                <span class="invalid-feedback">وارد کردن این فیلد الزامی است.</span>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-primary btn-menu-item-save">
                    <div class="spinner-border spinner-border-sm text-white d-none" role="status">
                        <span class="visually-hidden">در حال بارگذاری ...</span>
                    </div>
                    <span>ذخیره</span>
                </button>
                <button type="button" class="btn btn-sm btn-label-secondary btn-menu-item-cancel ms-2" data-bs-toggle="collapse" data-bs-target="{{'#item-' .$item->id}}">انصراف</button>
                <button type="button" class="btn btn-sm btn-danger btn-menu-item-delete ms-auto"><i class="bx bx-trash-alt"></i></button>
            </div>
        </div>
    </div>
</div>
