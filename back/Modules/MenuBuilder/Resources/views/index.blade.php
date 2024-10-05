@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت منوها /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    {{-- choose menu --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{route('menus.index')}}" class="d-flex align-items-lg-center flex-column flex-lg-row">
                <label class="form-label font-15 me-3">یک منو جهت ویرایش انتخاب کنید:</label>
                <select name="menu_id" id="menu_id" class="form-select mb-2 mb-lg-0" style="max-width: 200px;"
                        aria-label="menu_id">
                    @if($menus->count() < 1)
                        <option value="">هیچ منوی وجود ندارد</option>
                    @else
                        @if(!isset($menu))
                            <option value="" selected>هیچ منویی انتخاب نشده</option>
                        @endif
                        @foreach($menus as $m)

                            <option value="{{$m->id}}" {{isset($menu) && $menu->id == $m->id ? 'selected':''}}>{{$m->title}}</option>
                        @endforeach
                    @endif
                </select>
                <button type="submit" class="ms-lg-3 mb-2 mb-lg-0 btn btn-primary flex-shrink-0">انتخاب</button>
                <a href="{{route('menus.create')}}" class="ms-lg-auto btn btn-label-primary flex-shrink-0"><i
                            class="bx bx-plus me-2"></i><span>ساختن منوی جدید</span></a>
            </form>

        </div>
    </div>

    @if(isset($menu))
        <div class="row">
            {{-- add items to menu --}}
            <div class="col-lg-4 mb-4">
                <h5 class="">افزودن آیتم‌های منو</h5>
                <div class="accordion mt-3 accordion-header-primary" id="accordionSidebar">

                    {{-- add custom link --}}
                    <div class="card accordion-item active">
                        <h2 class="accordion-header">
                            <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#accordionSidebarCustomLink" aria-expanded="true">
                                افزودن لینک دلخواه
                            </button>
                        </h2>
                        <div id="accordionSidebarCustomLink" class="accordion-collapse collapse show"
                             data-bs-parent="#accordionSidebar">
                            <div class="accordion-body p-3 pt-1">
                                <div class="custom-item-form">
                                    <input type="hidden" name="menu_id" value="{{$menu->id}}">
                                    <div class="mb-2">
                                        <label class="form-label" for="title">عنوان</label>
                                        <input type="text" class="form-control form-control-sm" id="title" name="title">
                                        <span class="invalid-feedback">وارد کردن این مقدار ضروری است.</span>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="link">لینک</label>
                                        <input type="text" class="form-control form-control-sm" dir="ltr" id="link"
                                               name="link">
                                        <span class="invalid-feedback">وارد کردن این مقدار ضروری است.</span>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-sm btn-primary btn-add-menu-item">
                                            <div class="spinner-border spinner-border-sm text-white d-none"
                                                 role="status">
                                                <span class="visually-hidden">در حال بارگذاری ...</span>
                                            </div>
                                            افزودن آیتم
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- add product categories --}}
                    <div class="card accordion-item">
                        <h2 class="accordion-header">
                            <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#accordionSidebarCategories" aria-expanded="false">
                                دسته‌بندی محصولات
                            </button>
                        </h2>
                        <div id="accordionSidebarCategories" class="accordion-collapse collapse"
                             data-bs-parent="#accordionSidebar">
                            <div class="accordion-body p-3 pt-1">

                                @php $categories = \Modules\Products\Entities\Category::all(); @endphp
                                @if($categories->count() < 1)
                                    <p class="m-0">هیچ دسته‌بندی محصولی وجود ندارد.</p>
                                @else
                                    <div class="vertical-scrollable checklist-list" id="categories-list"
                                         style="max-height: 200px">
                                        <input type="hidden" name="menu_id" value="{{$menu->id}}">
                                        @foreach($categories as $category)
                                            <div class="form-check">
                                                <input class="form-check-input checklist-check" type="checkbox"
                                                       id="{{'cat-' . $category->id}}"
                                                       data-item-title="{{$category->title}}"
                                                       data-item-link="{{str_replace(url('/'),'/',route('category.show',$category))}}">
                                                <label class="form-check-label"
                                                       for="{{'cat-' . $category->id}}">{{$category->title}}</label>
                                            </div>
                                        @endforeach
                                    </div>


                                    <div class="border-top pt-3 mt-3 d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input checklist-check-all" type="checkbox"
                                                   id="checkAllCategories" data-list-id="#categories-list">
                                            <label class="form-check-label" for="checkAllCategories">انتخاب همه</label>
                                        </div>
                                        <button type="button"
                                                class="ms-auto btn btn-sm btn-primary btn-checklist-to-menu"
                                                data-list-id="#categories-list">
                                            <div class="spinner-border spinner-border-sm text-white d-none"
                                                 role="status">
                                                <span class="visually-hidden">در حال بارگذاری ...</span>
                                            </div>
                                            افزودن آیتم
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- add pages --}}
                    <div class="card accordion-item">
                        <h2 class="accordion-header">
                            <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#accordionSidebarPages" aria-expanded="false">
                                برگه ها
                            </button>
                        </h2>
                        <div id="accordionSidebarPages" class="accordion-collapse collapse"
                             data-bs-parent="#accordionSidebar">
                            <div class="accordion-body p-3 pt-1">

                                @php $pages = \Modules\Pages\Entities\Page::where('status','published')->get(); @endphp
                                @if($pages->count() < 1)
                                    <p class="m-0">هیچ برگه ای وجود ندارد.</p>
                                @else
                                    <div class="vertical-scrollable checklist-list" id="pages-list"
                                         style="max-height: 200px">
                                        <input type="hidden" name="menu_id" value="{{$menu->id}}">
                                        @foreach($pages as $page)
                                            <div class="form-check">
                                                <input class="form-check-input checklist-check" type="checkbox"
                                                       id="{{'page-' . $page->id}}" data-item-title="{{$page->title}}"
                                                       data-item-link="{{str_replace(url('/'),'/',route('page.show',$page))}}">
                                                <label class="form-check-label"
                                                       for="{{'page-' . $page->id}}">{{$page->title}}</label>
                                            </div>
                                        @endforeach
                                    </div>


                                    <div class="border-top pt-3 mt-3 d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input checklist-check-all" type="checkbox"
                                                   id="checkAllPages" data-list-id="#pages-list">
                                            <label class="form-check-label" for="checkAllPages">انتخاب همه</label>
                                        </div>
                                        <button type="button"
                                                class="ms-auto btn btn-sm btn-primary btn-checklist-to-menu"
                                                data-list-id="#pages-list">
                                            <div class="spinner-border spinner-border-sm text-white d-none"
                                                 role="status">
                                                <span class="visually-hidden">در حال بارگذاری ...</span>
                                            </div>
                                            افزودن آیتم
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- edit menu --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">ویرایش منو و آیتم‌های آن</h5>
                        <form action="{{route('menus.destroy',$menu)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-label-danger form-delete-btn"><i
                                        class="bx bx-trash"></i></button>
                        </form>
                    </div>

                    <form class="card-body" action="{{route('menus.update',$menu)}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- title --}}
                        <div class="d-flex align-items-lg-center">
                            <label for="title" class="flex-shrink-0 me-lg-3">عنوان منو:</label>
                            <input type="text" name="title" id="title" class="form-control" style="max-width: 250px;"
                                   value="{{old('title',$menu->title)}}">
                        </div>

                        <hr>

                        {{-- bllk selection --}}
                        <div class="bulk-selection {{$menu->items->count() < 1 ? 'd-none' : ''}}">
                            <div class="bg-label-secondary w-auto rounded mb-3 p-2 px-3 d-inline-flex flex-wrap">
                                <input type="hidden" id="menu_id" value="{{$menu->id}}">
                                <div class="form-check">
                                    <input class="form-check-input bulk-selection-check" type="checkbox"
                                           id="bulkSelectionCheck">
                                    <label class="form-check-label" for="bulkSelectionCheck">انتخاب دسته‌جمعی</label>
                                </div>
                                <div class="form-check ms-3 d-none delete-items-options">
                                    <input class="form-check-input bulk-selection-check-all" type="checkbox"
                                           id="bulkSelectionCheckAll">
                                    <label class="form-check-label" for="bulkSelectionCheckAll">انتخاب همه</label>
                                </div>
                            </div>
                        </div>


                        {{-- items --}}
                        <div class="accordion accordion-header-primary" id="accordionItems" data-depth="0">
                            @if($menu->items->count() < 1)
                                <p id="noItemsMsg">این منو فعلا هیچ آیتمی ندارد!</p>
                            @else
                                <div class="overlay-spinner">
                                    <div class="spinner-border spinner-border-lg text-secondary" role="status">
                                        <span class="visually-hidden">در حال بارگذاری ...</span>
                                    </div>
                                </div>
                                @foreach($menu->items()->where('parent_id',null)->get() as $item)
                                    <div class="accordion-item-container" data-depth="0">
                                        @include('menubuilder::menu_item',['item' => $item])

                                        {{-- sub items --}}
                                        <div class="nested-scrollable ps-5 mb-2" data-depth="1">
                                            @foreach($item->items()->get() as $subItem)
                                                <div class="accordion-item-container" data-depth="1">
                                                    @include('menubuilder::menu_item',['item' => $subItem])

                                                    {{-- sub items --}}
                                                    <div class="nested-scrollable ps-5 mb-2" data-depth="2">
                                                        @foreach($subItem->items()->get() as $subSubItem)
                                                            <div class="accordion-item-container" data-depth="2">
                                                                @include('menubuilder::menu_item',['item' => $subSubItem])
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        {{-- bllk selection --}}
                        <div class="bulk-selection {{$menu->items->count() < 1 ? 'd-none' : ''}}">
                            <div class="bg-label-secondary w-auto rounded mt-3 p-2 px-3 d-inline-flex flex-wrap">
                                <input type="hidden" id="menu_id" value="{{$menu->id}}">
                                <div class="form-check">
                                    <input class="form-check-input bulk-selection-check" type="checkbox"
                                           id="bulkSelectionCheckDown">
                                    <label class="form-check-label" for="bulkSelectionCheckDown">انتخاب
                                        دسته‌جمعی</label>
                                </div>
                                <div class="form-check ms-3 d-none delete-items-options">
                                    <input class="form-check-input bulk-selection-check-all" type="checkbox"
                                           id="bulkSelectionCheckAllDown">
                                    <label class="form-check-label" for="bulkSelectionCheckAllDown">انتخاب همه</label>
                                </div>
                                <button type="button"
                                        class="btn btn-sm btn-danger ms-3 delete-items-options btn-bulk-delete d-none">
                                    <div class="spinner-border spinner-border-sm text-white d-none" role="status">
                                        <span class="visually-hidden">در حال بارگذاری ...</span>
                                    </div>
                                    حذف آیتم‌های انتخابی
                                </button>
                            </div>
                            <div class="mb-3 d-none delete-items-options mt-3">
                                <span class="font-13 d-inline-block">آیتم‌های انتخاب شده:</span>
                                <div class="d-inline-block selected-items-to-delete"></div>
                            </div>
                        </div>

                        <hr>

                        {{-- locations --}}
                        <div class="mb-3">
                            <label class="form-label font-15" for="locations">جایگاه نمایش منو</label>
                            <small class="d-block mb-3 mt-1">توجه: میتوانید یک یا چند جایگاه برای منو انتخاب کنید تا منو
                                در جایگاه های مختلفی نمایش داده شود.</small>
                            <small class="d-block mb-3 mt-1">توجه: در هر جایگاه تنها یک منو نمایش داده میشود.</small>

                            <div class="form-check-inline">
                                <input class="form-check-input" aria-label="main_menu" name="locations[]"
                                       type="checkbox" value="main_menu" id="main_menu"
                                @if(old("locations"))
                                    {{ (in_array(trim('main_menu'), old("locations")) ? "checked":"") }}
                                        @else
                                    {{$menu->hasLocation('main_menu') ? "checked":""}}
                                        @endif>
                                <label class="form-check-label" for="main_menu">منوی اصلی</label>
                            </div>

                            <div class="form-check-inline">
                                <input class="form-check-input" aria-label="footer_list1" name="locations[]"
                                       type="checkbox" value="footer_list1" id="footer_list1"
                                @if(old("locations"))
                                    {{ (in_array(trim('footer_list1'), old("locations")) ? "checked":"") }}
                                        @else
                                    {{$menu->hasLocation('footer_list1') ? "checked":""}}
                                        @endif>
                                <label class="form-check-label" for="footer_list1">لیست فوتر 1</label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" aria-label="footer_list2" name="locations[]"
                                       type="checkbox" value="footer_list2" id="footer_list2"
                                @if(old("locations"))
                                    {{ (in_array(trim('footer_list2'), old("locations")) ? "checked":"") }}
                                        @else
                                    {{$menu->hasLocation('footer_list2') ? "checked":""}}
                                        @endif>
                                <label class="form-check-label" for="footer_list2">لیست فوتر 2</label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" aria-label="footer_list3" name="locations[]"
                                       type="checkbox" value="footer_list3" id="footer_list3"
                                @if(old("locations"))
                                    {{ (in_array(trim('footer_list3'), old("locations")) ? "checked":"") }}
                                        @else
                                    {{$menu->hasLocation('footer_list3') ? "checked":""}}
                                        @endif>
                                <label class="form-check-label" for="footer_list3">لیست فوتر 3</label>
                            </div>
                        </div>

                        {{-- submit --}}
                        <div class="py-3">
                            <button type="submit" class="btn btn-success submit-button px-5">ذخیره منو</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    @endif
@endsection

@section('styles')
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.form-delete-btn', function (e) {
            let btn = $(this);
            let form = btn.parent('form');
            e.preventDefault();
            Swal.fire({
                title: 'آیا مطمئنید؟',
                text: "این منو برای همیشه حذف میشود. این کار قابل بازگشت نیست!",
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
                    form.submit();
                }
            });
        });
    </script>
@endsection
