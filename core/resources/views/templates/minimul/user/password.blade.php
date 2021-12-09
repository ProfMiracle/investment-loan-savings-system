@extends(activeTemplate() .'layouts.user')
@section('import-css')
@stop

@section('style')
@stop
@section('content')

    @include(activeTemplate().'partials.breadcrumb')

    <!-- ========User-Panel-Section Starte Here ========-->
    <section class="user-panel-section padding-bottom padding-top">
        <div class="container user-panel-container">
            <div class=" user-panel-tab">
                <div class="row">
                    @include(activeTemplate().'partials.sidebar')

                    <div class="col-lg-9" id="myvideo">
                        <div class="user-panel-header mb-60-80">
                            <div class="left d-sm-block d-none">
                                <h6 class="title">{{__($page_title)}}</h6>
                            </div>
                            <ul class="right">
                                <li>
                                    <a href="#0" id="fullScreen"><i class="flaticon-ui-2"></i></a>
                                    <a href="#0" id="exitScreen"><i class="flaticon-ui-1"></i></a>
                                </li>
                                <li>
                                    <a href="#0" class="log-out d-lg-none">

                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>

                                            <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div>


                        <div class="tab-area fullscreen-width">
                            <div class="tab-item active">


                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            @csrf


                                            <div class="form-group">
                                                <label for="CurrentPassword" class="col-form-label">@lang('Current Password:')</label>
                                                <input type="text" class=" form-control  form-control-lg" id="CurrentPassword" name="current_password" placeholder="@lang('Current Password')">
                                            </div>

                                            <div class="form-group">
                                                <label for="password" class="col-form-label">@lang('New Password:')</label>
                                                <input type="text" class="form-control form-control-lg" id="password" name="password" placeholder="@lang('New Password')">
                                            </div>
                                            <div class="form-group ">
                                                    <label for="password_confirmation" class="col-form-label">@lang('Confirm Password:')</label>
                                                    <input type="text" class="form-control  form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="@lang('Confirm Password')">

                                            </div>

                                            <div class="form-group ">
                                                <button type="submit" class="custom-button bg-3  text-center mt-3">@lang('Change Password')</button>

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
    <!-- ========User-Panel-Section Ends Here ========-->
@endsection

