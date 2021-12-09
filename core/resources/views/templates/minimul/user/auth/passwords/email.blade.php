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
                                            <form method="POST" action="{{ route('user.password.email') }}" >
                                                @csrf

                                                <h2 class="text-center text-white pb-4 text-uppercase"> @lang($page_title)</h2>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-form-label">@lang('Your Email Address')</label>
                                                    <input type="email" name="email"  class="form-control"  id="InputName" placeholder="@lang('E-mail Address')"
                                                           required>
                                                </div>


                                                <div class="form-group ">
                                                    <button type="submit" class="custom-button bg-3  text-center mt-3">
                                                        @lang('Send Mail')
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

@endsection
