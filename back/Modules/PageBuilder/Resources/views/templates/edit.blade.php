@extends('admin.layouts.panel')
@section('content')
    <input type="hidden" id="template_id" value="{{$template->id}}">
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('templates.index')}}">قالب ها</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('templates.create')}}" class="btn btn-primary"><span><i
                        class="bx bx-plus me-sm-2"></i> <span
                        class="d-none d-sm-inline-block">افزودن قالب جدید</span></span></a>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])



    <div class="row">

        {{-- edit title --}}
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('templates.update',$template)}}" method="post" enctype="multipart/form-data"
                          class="row align-items-end" id="mainForm">
                        @csrf
                        @method('PATCH')
                        <div class="col-lg-10 mb-3 mb-lg-0">
                            <label class="form-label" for="title">عنوان قالب</label>
                            <input id="title" type="text" name="title" class="form-control"
                                   value="{{old('title',$template->title)}}">
                        </div>

                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-label-success submit-button w-100">ویرایش
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- widgets --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    @include('pagebuilder::templates.includes.widgets_list')
                </div>
            </div>
        </div>

        {{-- template content --}}
        <div class="col-lg-8">
            <div class="card bg-label-primary">
                <div class="card-body">
                    @if($template->rows->count() > 0)
                        <div class="d-flex align-items-start mb-5">
                           <div class="d-flex flex-column">
                               <h4 class="fw-bold">پیشنمایش ساختار قالب</h4>
                               <p>برای تغییر ترتیب نمایش، سطر ها را بکشید.</p>
                           </div>
                            <a href="{{route('template.preview',$template)}}" class="btn btn-dark ms-auto" target="_blank">
                                <i class="bx bx-show me-2"></i><span>پیشنمایش</span></a>
                        </div>

                        {{-- rows --}}
                        <div class="accordion mt-3 accordion-header-primary" id="accordionTemplate">
                            @foreach($template->rows()->orderBy('order','asc')->get() as $row)
                                @include('pagebuilder::templates.includes.template_row',$row)
                            @endforeach
                        </div>

                    @else


                        <div class="d-flex align-items-center rounded-3 p-5 bg-label-primary">
                            <div class="d-flex flex-column">
                                <h4 class="text-primary mb-2 fw-bold">یه صفحه خفن طراحی کن!</h4>
                                <p class="mb-0">برای شروع یکی از ویجت ها رو به صفحه اضافه کن</p>
                            </div>
                            <a href="{{route('template.preview',$template)}}" class="btn btn-dark ms-auto" target="_blank">
                                <i class="bx bx-show me-2"></i><span>پیشنمایش</span></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/js/custom/pagebuilder.js')}}"></script>
@endsection
