<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $general->sitename($page_title) }}</title>
    <!-- favicon -->
    <link rel="icon" href="{{get_image(config('constants.logoIcon.path') .'/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" type="image/png" href="{{ get_image(config('constants.logoIcon.path') .'/favicon.png') }}"/>
    @include('partials.seo')
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{asset('assets/templates/basic/css/bootstrap.min.css')}}">
    @yield('import-css')
    @stack('style-lib')
    <!-- animate.css -->
    <link rel="stylesheet" href="{{asset('assets/templates/basic/css/animate.css')}}">
    <!-- owl carousel css link -->
    <link rel="stylesheet" href="{{asset('assets/templates/basic/css/owl.carousel.min.css')}}">
    @include('partials.notify-css')
    <!-- main style css link -->
    {{--<link rel="stylesheet" href="{{asset('assets/templates/basic/css/style.css')}}">--}}

    <link rel="stylesheet" href="{{asset('assets/templates/basic/css/style.php')}}?color={{ $general->bclr}}&secondColor={{ $general->sclr}}">
    @yield('style')
</head>
<body >




<header class="inner-page-header">
    <div class="inner-page-header-shape"><img src="{{asset('assets/templates/basic/images/ami.png')}}" alt="image"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="inner-page-header-content">

                    <a href="{{url('/')}}">
                        <img src="{{get_image(config('constants.logoIcon.path') .'/logo.png')}}" alt="image">
                    </a>

                    <div class="login-area">
                        @guest
                        <a href="{{route('user.login')}}">@lang('Login')</a>
                        <a href="{{route('user.register')}}">@lang('Register')</a>
                        @else
                        <a href="{{route('user.logout')}}" class="mb-5">@lang('Sign Out')</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<div class="nav-box-area mt-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-2 col-md-4 col-6">
                <a href="{{route('home')}}">
                    <div class="box">
                        <p> @lang('Home') </p>
                        <i class="fas fa-home"></i>
                    </div>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="{{route('home.about')}}">
                    <div class="box">
                        <p> @lang('About Us') </p>
                        <i class="fas fa-address-card"></i>
                    </div>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="{{route('home.faq')}}">
                    <div class="box">
                        <p> @lang('FAQ') </p>
                        <i class="fas fa-comments"></i>
                    </div>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="{{route('home.contact')}}">
                    <div class="box">
                        <p> @lang('Contact') </p>
                        <i class="fas fa-envelope"></i>
                    </div>
                </a>
            </div>



            @foreach($company_policy as $policy)
                <div class="col-lg-2 col-md-4 col-6">
                    <a href="{{route('home.policy',[$policy, str_slug($policy->value->title)])}}">
                        <div class="box">
                            <p> {{__($policy->value->title)}} </p>
                            <i class="fas fa-pen-square"></i>
                        </div>
                    </a>
                </div>
            @endforeach




            <div class="col-lg-2 col-md-4 col-6">
                <a href="{{route('home.rules')}}">
                    <div class="box">
                        <p> @lang('Rules') </p>
                        <i class="fas fa-newspaper"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>


@yield('content')


@include(activeTemplate().'partials.footer')

<!-- jquery -->
<script src="{{asset('assets/templates/basic/js/jquery-3.3.1.min.js')}}"></script>
<!-- migarate-jquery -->
<script src="{{asset('assets/templates/basic/js/jquery-migrate-3.0.0.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset('assets/templates/basic/js/bootstrap.min.js')}}"></script>
@yield('import-js')
<!-- owl-carousel js -->
<script src="{{asset('assets/templates/basic/js/owl.carousel.min.js')}}"></script>
<!-- particle js -->
<script src="{{asset('assets/templates/basic/js/particles.js')}}"></script>
<!-- main -->
<script src="{{asset('assets/templates/basic/js/main.js')}}"></script>

@include('partials.notify-js')
@yield('script')
@stack('js')


</body>
</html>
