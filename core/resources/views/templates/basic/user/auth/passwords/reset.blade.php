@extends(activeTemplate() .'layouts.form')

@section('content')


<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <form action="{{ route('user.password.update') }}" method="POST" class="login-form">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <h2 class="text-center text-white pb-4 text-uppercase"> @lang('Reset Password')</h2>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">@lang('New Password:')</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password" placeholder="@lang('New Password')" name="password" required="" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">@lang('Retype New Password:')</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password_confirmation" placeholder="@lang('Confirm Password')" name="password_confirmation" required="" value="">
                    </div>
                </div>

                <div class="form-group row pt-5">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-default website-color">@lang('Reset Password')</button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-9 col-12 text-center">
                        <div class="remember mr-5">
                            <label class="form-check-label" for="gridCheck1">

                                <a href="{{ route('user.login') }}" >@lang('Login Here')</a>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    


@endsection
