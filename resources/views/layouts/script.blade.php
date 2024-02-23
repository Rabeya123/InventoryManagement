        <!-- CORE PLUGINS -->
        <script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/popper.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/metisMenu.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <!-- PAGE LEVEL PLUGINS -->
        {{-- <script src="{{asset('js/Chart.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/jquery-jvectormap-2.0.3.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/jquery-jvectormap-world-mill-en.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/jquery-jvectormap-us-aea-en.js')}}" type="text/javascript"></script> --}}
        <script src="{{asset('js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/jquery.timepicker.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/toastr.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/select2.min.js')}}" type="text/javascript"></script>

        <!-- CORE SCRIPTS-->
        <script src="{{asset('js/theme_app.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
        {!! Toastr::message() !!}

        <script>
                $('.date').datepicker({ autoclose: true });
                $('.select_item_list').select2();
        </script>
