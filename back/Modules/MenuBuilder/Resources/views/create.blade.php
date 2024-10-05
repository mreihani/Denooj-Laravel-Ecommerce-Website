@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('menus.index')}}">مدیریت منوها</a> /</span> ایجاد منو جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
   <div class="row">
       <div class="col-lg-8">
           <div class="card mb-4">
               <div class="card-body">
                   <form action="{{route('menus.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
                       @csrf
                       <div class="mb-3 col-lg-4">
                           <label class="form-label" for="title">عنوان</label>
                           <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
                       </div>
                       <div class="col-12">

                       </div>
                       <div class="mb-3 col-12">
                           <label class="form-label font-15" for="locations">جایگاه نمایش منو</label>
                           <small class="d-block mb-3 mt-1">توجه: میتوانید یک یا چند جایگاه برای منو انتخاب کنید تا منو در جایگاه های مختلفی نمایش داده شود.</small>
                           <small class="d-block mb-3 mt-1">توجه: در هر جایگاه تنها یک منو نمایش داده میشود.</small>

                           <div class="form-check-inline">
                               <input class="form-check-input" aria-label="main_menu" name="locations[]" type="checkbox" value="main_menu" id="main_menu"
                               @if(old("locations")) {{ (in_array(trim('main_menu'), old("locations")) ? "checked":"") }}@endif>
                               <label class="form-check-label" for="main_menu">منوی اصلی</label>
                           </div>

                           <div class="form-check-inline">
                               <input class="form-check-input" aria-label="footer_list1" name="locations[]" type="checkbox" value="footer_list1" id="footer_list1"
                               @if(old("locations")) {{ (in_array(trim('footer_list1'), old("locations")) ? "checked":"") }}@endif>
                               <label class="form-check-label" for="footer_list1">لیست فوتر 1</label>
                           </div>
                           <div class="form-check-inline">
                               <input class="form-check-input" aria-label="footer_list2" name="locations[]" type="checkbox" value="footer_list2" id="footer_list2"
                               @if(old("locations")) {{ (in_array(trim('footer_list2'), old("locations")) ? "checked":"") }}@endif>
                               <label class="form-check-label" for="footer_list2">لیست فوتر 2</label>
                           </div>
                           <div class="form-check-inline">
                               <input class="form-check-input" aria-label="footer_list3" name="locations[]" type="checkbox" value="footer_list3" id="footer_list3"
                               @if(old("locations")) {{ (in_array(trim('footer_list3'), old("locations")) ? "checked":"") }}@endif>
                               <label class="form-check-label" for="footer_list3">لیست فوتر 3</label>
                           </div>

                       </div>
                       <div class="mt-3">
                           <button type="submit" class="btn btn-primary submit-button">ایجاد منو</button>
                           <a href="{{route('menus.index')}}" class="btn btn-label-secondary ms-3">انصراف</a>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>

@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
