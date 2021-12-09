@extends(activeTemplate() .'layouts.master')
@section('content')

    @include(activeTemplate().'partials.frontend-breadcrumb')

    <div class="account--section sign-in-section active relative">
        <div class="container-fluid">
            <div class="account--area">
                <div class="account--thumb">
                    <img src="{{asset('assets/templates/minimul/images/account/sign-in.png')}}" alt="account">
                </div>
                <div class="account--content">
                    <h4 class="title">@lang('Sign in your account')</h4>
                        <form action="{{ route('user.login') }}" method="POST"  class="account-form" id="recaptchaForm">
                        @csrf
                        <div class="form-group">
                            <label class="fixlabel" for="email1">
                                <i class="fas fa-user-circle"></i>
                            </label>
                            <input type="text" id="exampleInputUsername"  name="username" value="{{old('username')}}" class="form-control" placeholder="@lang('Username')" >
                        </div>

                        <div class="form-group">
                            <label class="fixlabel" for="pass1">
                                <i class="fas fa-unlock"></i>
                            </label>
                            <input type="password" name="password" value="{{old('password')}}" class="form-control" placeholder="@lang('Password')">

                        </div>
                        <div class="form-group check-group">
                            <input id="check02" type="checkbox">
                            <label for="check02">
                                <a href="{{route('user.password.request')}}">@lang('Forget Password')</a>
                            </label>
                        </div>
                        <div class="form-group">
                            <input type="submit"  id="recaptcha"  class="submit-form-btn" value="@lang('SIGN IN')">
                        </div>
                        <div class="form-group">
                            @lang("Don`t have on account yet?")
                            <a href="{{route('user.register')}}" class=" d-block">@lang('Create Account')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ========Header-Section Ends Here ========-->


    <script src="//code.jquery.com/jquery-3.4.1.min.js"></script>
    @php echo recaptcha() @endphp

@endsection
