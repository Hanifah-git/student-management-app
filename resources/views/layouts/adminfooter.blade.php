<!-- Start Footer Area  -->
<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 col-md-9 ms-auto">
                <div class="row border-top pt-3 mt-3">
                    <div class="col-md-6 text-center">
                        <ul class="list-inline">
                            <li class="list-inline-item me-2">
                                <a href="javascript:void(0);">Data Land Technology Co.,Ltd</a>
                            </li>
                            <li class="list-inline-item me-2">
                                <a href="javascript:void(0);">About</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-center">
                        <p>&copy; <span id="getyear"></span> Copyright. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer Area  -->

<!-- Start Right Navbar  -->
<div class="right-panels">
    <h6>Custom your template</h6>
    <p class="small">Hifi!! here you can change your theme</p>
    <hr />
    <div class="themecolors">
        <a href="javascript:void(0);"><i class="fas fa-square text-priamry shadow fa-lg"></i></a>
        <a href="javascript:void(0);"><i class="fas fa-square text-secondary shadow fa-lg"></i></a>
        <a href="javascript:void(0);"><i class="fas fa-square text-info shadow fa-lg"></i></a>
        <a href="javascript:void(0);"><i class="fas fa-square text-success shadow fa-lg"></i></a>
        <a href="javascript:void(0);"><i class="fas fa-square text-warning shadow fa-lg"></i></a>
        <a href="javascript:void(0);"><i class="fas fa-square text-danger shadow fa-lg"></i></a>
        <a href="javascript:void(0);"><i class="fas fa-square text-muted shadow fa-lg"></i></a>
        <a href="javascript:void(0);"><i class="fas fa-square text-white shadow fa-lg"></i></a>
        <a href="javascript:void(0);"><i class="fas fa-square text-dark shadow fa-lg"></i></a>
        <a href="javascript:void(0);"><i class="fas fa-square text-light shadow fa-lg"></i></a>
    </div>
</div>
<!-- End Right Navbar  -->

{{-- Start Modal Area --}}
{{-- Start Quicksearch Modal --}}
{{-- End Quicksearch Modal --}}
{{-- End Modal Area --}}



{{-- jquery --}}
{{-- <script src="{{asset('assets/libs/jquery-3.7.1.min.js')}}" type="text/javascript"></script> --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
{{-- bootstrap css1 js1 --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
{{-- jquery ui css1 js1 --}}
<script src="{{ asset('assets/libs/jquery-ui-1.13.2.custom/jquery-ui.min.js') }}" type="text/javascript"></script>
{{-- google chart js1 --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{-- chartjs js1 --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- Raphael must be included before justgage --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.9/justgage.min.js"></script>
{{-- custom js js1 --}}
<script src="{{ asset('assets/dist/js/app.js') }}" type="text/javascript"></script>
{{-- toastr notification  css1 js1 --}}
{{-- <script src="{{ asset('assets/libs/toastr-master/build/toastr.min.js') }}"></script> --}}
<script src="{{ asset('assets/libs/tostr-master/tostr.js') }}"></script>

@if (Session::has('success'))
    <script>
        createToast("{{ session()->get('success') }}", SUCCESS, TOP_RIGHT, 0.25, 2.5, 0.25, SLIDE_IN)
    </script>
@endif


@if (Session::has('info'))
    <script>
        createToast("{{ session()->get('info') }}", WARNING, TOP_RIGHT, 0.25, 2.5, 0.25, SLIDE_IN)
    </script>
@endif

@if (Session::has('error'))
    <script>
        createToast("{{ session()->get('error') }}", ERROR, TOP_RIGHT, 0.25, 2.5, 0.25, SLIDE_IN)
    </script>
@endif


@if ($errors)
    @foreach ($errors->all() as $error)
        <script>
            createToast("{{$error}}", ERROR, TOP_RIGHT, 0.25, 2.5, 0.25, SLIDE_IN)
        </script>
    @endforeach
@endif



{{-- extra js --}}
@yield('scripts')
</body>

</html>
