@extends(activeTemplate() .'layouts.form')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <form class="contact-form" action="{{ route('user.password.email') }}" method="post">
                    @csrf
                    <h2 class="text-center text-white pb-4 text-uppercase"> {{$page_title}}</h2>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">@lang('E-mail Address'):</label>
                        <div class="col-sm-8">
                            <input type="email" name="email"  class="form-control"  id="InputName" placeholder="@lang('E-mail Address')"
                            required>
                        </div>
                    </div>
                    <div class="form-group row pt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-default website-color">@lang('Send Mail')</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9 col-12 text-center">
                            <div class="remember mr-5">
                                <label class="form-check-label" for="gridCheck1">
                                    <a href="{{route('user.login')}}">  @lang('Back To Login Page.')</a>
                                </label>
                            </div>
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
