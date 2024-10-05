@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">داستان ها /</span>لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('stories.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('stories.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('stories.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></a>
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($stories->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>بندانگشتی</th>
                        <th>عنوان</th>
                        <th>نوع</th>
                        <th>داستان</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($stories as $story)
                        <tr>
                            <td>
                                <a href="{{$story->getThumbnail()}}" target="_blank">
                                    <img src="{{$story->getThumbnail()}}" alt="image" class="rounded" style="width: 80px;">
                                </a>
                            </td>
                            <td style="max-width: 200px;">{{$story->title}}</td>
                            <td style="max-width: 300px;">
                                @if($story->type == 'video')
                                    <span><i class="bx bx-video"></i> ویدیو</span>

                                @elseif($story->type == 'image')
                                    <span><i class="bx bx-image"></i> عکس</span>
                                @else
                                    ----
                                @endif
                            </td>
                            <td>
                                @if($story->type == 'video')
                                    <video width="180" controls>
                                        <source src="{{$story->video_url}}" type="video/mp4">
                                    </video>
                                @elseif($story->type == 'image')
                                    <a href="{{$story->getImage()}}" target="_blank"><img src="{{$story->getImage()}}" alt="img" style="width: 180px; height: auto;"></a>
                                @else
                                    ----
                                @endif
                            </td>
                            <td>
                                @if($story->status == 'published')
                                    <span class="badge bg-label-success">منتشر شده</span>
                                @elseif($story->status == 'draft')
                                    <span class="badge bg-label-secondary">پیش نویس</span>
                                @else
                                    ----
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('stories.edit',$story)}}"><i class="bx bx-edit-alt me-1"></i> ویرایش</a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('stories.destroy',$story)}}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <span>حذف</span>
                                            </form>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$stories->links()}}
        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
