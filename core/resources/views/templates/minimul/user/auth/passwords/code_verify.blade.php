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
                                        <form action="{{ route('user.password.verify-code') }}" method="POST" >
                                            @csrf

                                            <h2 class="text-center text-white pb-4 text-uppercase"> @lang($page_title)</h2>

                                            <input type="hidden" name="email" value="{{ $email }}">

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-form-label">@lang('Verification Code')</label>
                                                <input type="text" name="code" id="pincode-input" class="magic-label form-control">
                                            </div>


                                            <div class="form-group ">
                                                <button type="submit" class="custom-button bg-3  text-center mt-3">
                                                    @lang('Verify Code')
                                                </button>
                                            </div>

                                            <div class="form-group">

                                                <div class="remember mr-5">
                                                    <label class="form-check-label" for="gridCheck1">
                                                        <a  href="{{ route('user.password.request') }}"> @lang('Try to send again')</a>

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
