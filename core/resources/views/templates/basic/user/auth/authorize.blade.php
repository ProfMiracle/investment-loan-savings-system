@extends(activeTemplate().'layouts.form')
@section('title','SMS verification form')
@section('content')
    @if(!$user->status)
        <div class="rules-area my-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-page main-page--style">
                            <div class="card-body my-3">
                                <p>
                                    {{__($page_title)}}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(!$user->ev)

        <div class="container py-5">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <form method="POST" action="{{route('user.verify_email')}}" class="mb-4">
                        @csrf
                        <h2 class="text-center text-white pb-4 text-uppercase"> @lang($page_title)</h2>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" readonly value="{{auth()->user()->email}}">


                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-9">
                                <input  name="email_verified_code" placeholder="@lang('Code')" class="form-control">

                                @if ($errors->has('email_verified_code'))
                                    <small class="text-danger">{{ $errors->first('email_verified_code') }}</small>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row pt-5">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-default website-color">@lang('Submit')</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 col-12 text-center">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @elseif(!$user->sv)

        <div class="container py-5">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <form method="POST" action="{{route('user.verify_sms')}}" class="contact-form mb-4">
                        @csrf
                        <h2 class="text-center text-white pb-4 text-uppercase"> @lang($page_title)</h2>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-9">
                                <input type="text" name="mobile" class="form-control" readonly value="{{auth()->user()->mobile}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-9">
                                <input  name="sms_verified_code" placeholder="@lang('Code')" class="form-control">
                                @if ($errors->has('sms_verified_code'))
                                    <small class="text-danger">{{ $errors->first('sms_verified_code') }}</small>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row pt-5">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-default website-color">@lang('Submit')</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 col-12 text-center">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>



    @elseif(!$user->tv)


        <div class="container py-5">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <form class="contact-form" method="POST" action="{{route('user.go2fa.verify') }}">
                        @csrf
                        <h2 class="text-center text-white pb-4 text-uppercase"> @lang($page_title)</h2>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-7">
                                <strong> {{\Carbon\Carbon::now()}}</strong>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">@lang("Google Authenticator Code")</label>
                            <div class="col-sm-7">
                                <input  name="code" placeholder="@lang('Enter Google Authenticator Code')" class="form-control">
                                @if ($errors->has('code'))
                                    <small class="text-danger">{{ $errors->first('code') }}</small>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row pt-2">
                            <div class="col-sm-7 offset-md-4 text-center">
                                <button type="submit" class="btn btn-block btn-default website-color">@lang('Submit')</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    @else
        <script>
            window.location.href = "{{route('user.home')}}";
        </script>


    @endif

    <div class="sec-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sec"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
