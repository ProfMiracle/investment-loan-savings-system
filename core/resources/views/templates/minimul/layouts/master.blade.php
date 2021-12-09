<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $general->sitename($page_title) }}</title>
    <link rel="icon" href="{{get_image(config('constants.logoIcon.path') .'/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" type="image/png" href="{{ get_image(config('constants.logoIcon.path') .'/favicon.png') }}"/>

    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/bootstrap.min.css')}}">
    @yield('import-css')
    @stack('style-lib')
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/odometer.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/magnific-popup.css')}}">
    @include('partials.notify-css')
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/odometer.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/minimul/css/style.php')}}?color={{ $general->bclr}}">

    @yield('style')
</head>
<body>




<div class="main-section">
    @include(activeTemplate().'partials.header')

@yield('content')


    @include(activeTemplate().'partials.footer')
</div>


<script src="{{asset('assets/templates/minimul/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/modernizr-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/plugins.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/owl.min.js')}}"></script>
@yield('load-js')
<script src="{{asset('assets/templates/minimul/js/swiper.min.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/wow.min.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/odometer.min.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/viewport.jquery.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/nice-select.js')}}"></script>
@include('partials.notify-js')
<script src="{{asset('assets/templates/minimul/js/paroller.js')}}"></script>
<script src="{{asset('assets/templates/minimul/js/main.js')}}"></script>
@yield('script')
@stack('js')
<script>
    $(document).on("change", ".langSel", function() {
        window.location.href = "{{url('/')}}/change-lang/"+$(this).val() ;
    });
</script>


@php
    if($plugins[0]->status == 1){
        $appKeyCode = $plugins[0]->shortcode->app_key->value;
        $twakTo = str_replace("{{app_key}}",$appKeyCode,$plugins[0]->script);
        echo $twakTo;
    }
@endphp


</body>
</html>
