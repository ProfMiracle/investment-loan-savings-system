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
                                        <h2 class="text-center">@lang('Reset Password')</h2>
                                        <form method="POST" action="{{ route('user.password.update') }}" >
                                            @csrf

                                            <input type="hidden" name="email" value="{{ $email }}">
                                            <input type="hidden" name="token" value="{{ $token }}">

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-form-label">@lang('New Password')</label>
                                                <input type="password" class="form-control" id="password" placeholder="@lang('New Password')" name="password" required="" value="">
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-form-label">@lang('Retype New Password')</label>
                                                <input type="password" class="form-control" id="password_confirmation" placeholder="@lang('Confirm Password')" name="password_confirmation" required="" value="">
                                            </div>


                                            <div class="form-group ">
                                                <button type="submit" class="custom-button bg-3  text-center mt-3">
                                                    @lang('Reset Password')
                                                </button>
                                            </div>


                                            <div class="form-group">

                                                <div class="remember mr-5">
                                                    <label class="form-check-label" for="gridCheck1">
                                                        <a href="{{ route('user.login') }}" >@lang('Login Here')</a>
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

@endsection
