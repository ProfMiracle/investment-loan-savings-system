@extends(activeTemplate() .'layouts.user')


@section('style')
@endsection
@section('content')

    <div class="inner-banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="title"><span>{{__($page_title)}}</span></h2>
                </div>

            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <form class="contact-form" action="" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="form-group row">
                        <label for="CurrentPassword" class="col-sm-3 col-form-label">@lang('Current Password:')</label>
                        <input type="text" class="col-sm-9 form-control" id="CurrentPassword" name="current_password" placeholder="@lang('Current Password')">
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">@lang('New Password:')</label>
                        <input type="text" class="col-sm-9 form-control" id="password" name="password" placeholder="@lang('New Password')">
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-3 col-form-label">@lang('Confirm Password:')</label>
                        <input type="text" class="col-sm-9 form-control" id="password_confirmation" name="password_confirmation" placeholder="@lang('Confirm Password')">
                    </div>


                    <div class="form-group row pt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-danger">@lang('Change Password')</button>
                        </div>
                    </div>




                </form>
            </div>
        </div>
    </div>



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
