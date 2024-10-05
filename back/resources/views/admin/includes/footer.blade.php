<footer class="content-footer footer bg-footer-theme">
    <div class="container-fluid d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            <i class="bx bx-copyright me-1"></i>کپی رایت {{\Carbon\Carbon::now()->year}}
            <a href="{{url('/')}}" target="_blank" class="footer-link fw-semibold">{{config('app.app_name_fa')}}</a>
        </div>
        <div>
            <a href="{{url('/')}}" target="_blank" class="footer-link me-4">مشاهده سایت</a>
        </div>
    </div>
</footer>
