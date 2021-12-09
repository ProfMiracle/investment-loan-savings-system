@extends(activeTemplate() .'layouts.master')
@section('style')
    <style>
        .account--section .account--area .account--content {
            width: 100%;
            max-width: 580px;
        }
    </style>
@stop
@section('content')

    @if(!$user->status)
        <!-- ========Feature-Section Starts Here ========-->
        <section class="page-header">
            <div class="elepsis header-trop">
                <img src="{{asset('assets/templates/minimul/images/profit/elepsis.png')}}" alt="profit">
            </div>
            <div class="circle-2 header-trop" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
                 data-paroller-type="foreground" data-paroller-direction="horizontal">
                <img src="{{asset('assets/images/frontend/animation/05.png')}}" alt="shape">
            </div>
            <div class="circle-3 header-trop" data-paroller-factor="0.10" data-paroller-factor-lg="-0.30"
                 data-paroller-type="foreground" data-paroller-direction="horizontal">
                <img src="{{asset('assets/images/frontend/animation/08.png')}}" alt="shape">
            </div>
            <div class="star-4 header-trop">
                <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
            </div>
            <div class="star-4 two header-trop">
                <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
            </div>
            <div class="star-5 header-trop">
                <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
            </div>
            <div class="circle-1 two header-trop">
                <img src="{{asset('assets/images/frontend/animation/10.png')}}" alt="shape">
            </div>
            <div class="trop-4 header-trop">
                <img src="{{asset('assets/images/frontend/animation/14.png')}}" alt="animation">
            </div>
            <div class="trop-3 header-trop">
                <img src="{{asset('assets/images/frontend/animation/13.png')}}" alt="animation">
            </div>
            <div class="circle-1 three header-trop">
                <img src="{{asset('assets/images/frontend/animation/12.png')}}" alt="animation">
            </div>
            <div class="circle-2 header-trop" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
                 data-paroller-type="foreground" data-paroller-direction="horizontal">
                <img src="{{asset('assets/images/frontend/animation/05.png')}}" alt="shape">
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-content">
                            <h2 class="title">{{__('Authorization')}}</h2>
                            <ul class="breadcrumb">
                                <li>
                                    <a href="{{route('home')}}">@lang('Home')</a>
                                </li>
                                <li>
                                    {{__('Authorization')}}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="page-header-thumb wow slideInDown">
                            <img src="{{asset('assets/images/frontend/breadcrumb/page-header-01.png')}}"
                                 alt="page-header">
                            <div class="coin wow bounceInDown" data-wow-delay=".5s">
                                <img src="{{asset('assets/images/frontend/breadcrumb/coin.png')}}" alt="page-header">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========Feature-Section Eventes Here ========-->

        <div class="account--section sign-in-section active relative">
            <div class="container-fluid">
                <div class="account--area">
                    <h4 class="title text-center text-danger">{{__($page_title)}}</h4>

                </div>
            </div>
        </div>
    @elseif(!$user->ev)
        @include(activeTemplate().'partials.frontend-breadcrumb')
        <section class="user-panel-section padding-bottom padding-top">
            <div class="container user-panel-container">
                <div class=" user-panel-tab">
                    <div class="row justify-content-center">


                        <div class="col-lg-8" id="myvideo">


                            <div class="tab-area fullscreen-width">
                                <div class="tab-item active">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <form method="POST" action="{{route('user.verify_email')}}" >
                                                @csrf

                                                <h2 class="text-center text-white pb-4 text-uppercase"> @lang($page_title)</h2>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-form-label">@lang('Your Email Address')</label>
                                                    <input type="email" name="email" class="form-control form-control-lg" readonly value="{{auth()->user()->email}}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-form-label">@lang('Enter Code')</label>
                                                    <input  name="email_verified_code" placeholder="@lang('Code')" class="form-control form-control-lg">

                                                    @if ($errors->has('email_verified_code'))
                                                        <small class="text-danger">{{ $errors->first('email_verified_code') }}</small>
                                                    @endif
                                                </div>



                                                <div class="form-group ">
                                                    <button type="submit" class="custom-button bg-3  text-center mt-3">
                                                        @lang('Submit')
                                                    </button>
                                                </div>

                                                <div class="form-group">

                                                        <div class="remember mr-5">
                                                            <label class="form-check-label" for="gridCheck1">
                                                                @lang('When don\'t sent any code your email') <a href="{{route('user.send_verify_code')}}?type=email"> @lang('Resend code')</a>
                                                                @if ($errors->has('resend'))
                                                                    <br/>
                                                                    <small class="text-danger">{{ $errors->first('resend') }}</small>
                                                                @endif

                                                            </label>
                                                        </div>

                                                </div>

                                            </form>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @elseif(!$user->sv)

        @include(activeTemplate().'partials.frontend-breadcrumb')


        <section class="user-panel-section padding-bottom padding-top">
            <div class="container user-panel-container">
                <div class=" user-panel-tab">
                    <div class="row justify-content-center">


                        <div class="col-lg-8" id="myvideo">


                            <div class="tab-area fullscreen-width">
                                <div class="tab-item active">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <form method="POST" action="{{route('user.verify_sms')}}" >
                                                @csrf

                                                <h2 class="text-center text-white pb-4 text-uppercase"> @lang($page_title)</h2>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-form-label">@lang('Your Mobile Number')</label>
                                                    <input type="text" name="mobile" class="form-control" readonly value="{{auth()->user()->mobile}}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-form-label">@lang('Enter Code')</label>
                                                    <input  name="sms_verified_code" placeholder="@lang('Code')" class="form-control form-control-lg">

                                                    @if ($errors->has('sms_verified_code'))
                                                        <small class="text-danger">{{ $errors->first('sms_verified_code') }}</small>
                                                    @endif
                                                </div>



                                                <div class="form-group ">
                                                    <button type="submit" class="custom-button bg-3  text-center mt-3">
                                                        @lang('Submit')
                                                    </button>
                                                </div>

                                                <div class="form-group">

                                                    <div class="remember mr-5">
                                                        <label class="form-check-label" for="gridCheck1">
                                                            @lang('When don\'t sent any code your phone') <a  href="{{route('user.send_verify_code')}}?type=phone"> @lang('Resend code')</a>
                                                            @if ($errors->has('resend'))
                                                                <br/>
                                                                <small class="text-danger">{{ $errors->first('resend') }}</small>
                                                            @endif

                                                        </label>
                                                    </div>

                                                </div>

                                            </form>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @elseif(!$user->tv)

        @include(activeTemplate().'partials.frontend-breadcrumb')


        <section class="user-panel-section padding-bottom padding-top">
            <div class="container user-panel-container">
                <div class=" user-panel-tab">
                    <div class="row justify-content-center">


                        <div class="col-lg-8" id="myvideo">


                            <div class="tab-area fullscreen-width">
                                <div class="tab-item active">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <form method="POST"  action="{{route('user.go2fa.verify') }}" >
                                                @csrf

                                                <h2 class="text-center text-white pb-4 text-uppercase"> @lang($page_title)</h2>
                                                <strong> {{\Carbon\Carbon::now()}}</strong>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-form-label">@lang('Google Authenticator Code')</label>
                                                    <input  name="code" placeholder="@lang('Enter Google Authenticator Code')" class="form-control">
                                                    @if ($errors->has('code'))
                                                        <small class="text-danger">{{ $errors->first('code') }}</small>
                                                    @endif
                                                </div>


                                                <div class="form-group ">
                                                    <button type="submit" class="custom-button bg-3  text-center mt-3">
                                                        @lang('Submit')
                                                    </button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @else
        <script>
            window.location.href = "{{route('user.home')}}";
        </script>
    @endif
@endsection
