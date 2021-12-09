@extends(activeTemplate() .'layouts.form')
@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">

                @if($errors->any())
                    <ul>
                        @foreach($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form action="{{ route('user.login') }}" method="POST" id="recaptchaForm">
                    @csrf
                    <h2 class="text-center text-white pb-4 text-uppercase"> {{__($page_title)}}</h2>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">@lang('Username:')</label>
                        <div class="col-sm-9">
                            <input type="text" id="exampleInputUsername"  name="username" value="{{old('username')}}" class="form-control" placeholder="@lang('Enter Username')" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">@lang('Password:')</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" value="{{old('password')}}" class="form-control" placeholder="@lang('Enter Password')">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-md-4 offset-md-2">
                            <input type="checkbox" name="remember" data-width="100%" data-onstyle="success"
                                   data-offstyle="danger" id="user-checkbox">
                            <label for="user-checkbox" class="">Remember me</label>
                        </div>
                    </div>
                    <div class="form-group row pt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-default website-color" id="recaptcha">@lang('Sign in')</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9 col-12 text-center">
                            <div class="remember mr-5">
                                <label class="form-check-label" for="gridCheck1">
                                    <a href="{{route('user.password.request')}}">  @lang('Forgot your login information.')</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>


                <script src="//code.jquery.com/jquery-3.4.1.min.js"></script>
                        @php echo recaptcha() @endphp
            </div>
        </div>
    </div>


@endsection
