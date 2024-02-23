
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bondstein Technologies</title>

       <!-- GLOBAL MAINLY STYLES-->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" />
        <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />
        <link href="{{asset('css/themify-icons.css')}}" rel="stylesheet" />
        <!-- THEME STYLES-->
        <link href="{{asset('css/main.css')}}" rel="stylesheet">
         <!-- PAGE LEVEL STYLES-->
        <link href="{{asset('css/auth-light.css')}}" rel="stylesheet" />
        <style>
            
            html > body{ 
                background-image: url('{{ asset('assets/img/bodybackground.jpg') }}'); 
                background-size: cover;
            }
            html > body:before {
                background: linear-gradient(to bottom, #787878 0%, rgba(52, 52, 52, 0.6) 100%);
                display: block;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                content: '';
            }
            .content{
                position: relative;
                box-sizing: border-box;
                vertical-align: top;
                margin-top: 150px;
            }
        </style>
        @stack('styles')
    </head>
    <body class="bg-silver-300">
        
        @yield('content')
        
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>

        <!-- CORE PLUGINS -->
    <script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="{{asset('js/jquery.validate.min.js')}}" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="{{asset('js/theme_app.js')}}" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            // $('.relaoding-animation').click(function(){
            //     $(this).html(" <i class=\"fa fa-spinner fa-spin\" aria-hidden=\"true\"></i> Please wait.....");
            //     $(this).prop('disabled', true);
            // });
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>

     <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    @stack('scripts')
    </body>
</html>
