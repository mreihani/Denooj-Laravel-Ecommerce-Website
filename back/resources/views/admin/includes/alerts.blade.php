<div class="@if(isset($class)) {{$class}} @endif">
    @if($errors->count() > 0)
        <div class="alert alert-danger">
            @if($errors->count() > 1)
            <b class="d-block mb-3">لطفا خطاهای زیر را رفع کنید:</b>
            @endif
            <ul class="pr-3 m-0">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-solid-success">{{session('success')}}</div>
    @endif

        @if(session()->has('error'))
            <div class="alert alert-solid-danger">{{session('error')}}</div>
        @endif

        @if(session()->has('info'))
            <div class="alert alert-solid-info">{{session('info')}}</div>
        @endif
</div>
