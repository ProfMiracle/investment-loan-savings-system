@extends(activeTemplate() .'layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/admin/build/css/intlTelInput.css')}}">
    <style>
        .intl-tel-input {
            position: relative;
            display: inline-block;
            width: 100%;
        !important;
        }
    </style>
@endsection
@section('content')

    @include(activeTemplate().'partials.frontend-breadcrumb')

    <div class="account--section sign-in-section active relative">
        <div class="container-fluid">
            <div class="account--area">
                <div class="account--thumb">
                    <img src="{{asset('assets/templates/minimul/images/account/sign-up.png')}}" alt="account">
                </div>
                <div class="account--content">
                    <h4 class="title">@lang('Sign Up your account')</h4>
                    <form action="{{ route('user.register') }}" method="POST" class="account-form" id="recaptchaForm">
                        @csrf
                        @isset($reference)
                            <div class="form-group">
                                <label class="fixlabel" for="email1">
                                    <i class="fas fa-user-circle"></i>
                                </label>
                                <input type="text" name="referBy" class="form-control" id="referenceBy"
                                       value="{{$reference}}" placeholder="@lang('Reference BY')" readonly/>
                            </div>
                        @endisset


                        <div class="form-group">
                            <label class="fixlabel" for="InputFirstname">
                                <i class="fas fa-user-circle"></i>
                            </label>
                            <input type="text" class="form-control" id="InputFirstname" name="firstname"
                                   placeholder="@lang('First Name')" value="{{old('firstname')}}" required="">
                        </div>

                        <div class="form-group">
                            <label class="fixlabel" for="lastname">
                                <i class="fas fa-user-circle"></i>
                            </label>
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                   placeholder="@lang('Last Name')" value="{{old('lastname')}}" required="">
                        </div>


                        <div class="form-group">
                            <label class="fixlabel" for="email1">
                                <i class="fas fa-user-circle"></i>
                            </label>
                            <input type="text" id="exampleInputUsername" name="username" value="{{old('username')}}"
                                   class="form-control" placeholder="@lang('Username')">
                        </div>

                        <div class="form-group">
                            <label class="fixlabel" for="email1">
                                <i class="fas fa-user-circle"></i>
                            </label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="@lang('E-mail Address')" value="{{old('email')}}" required="">
                        </div>

                        <div class="form-group">
                            <label class="fixlabel" for="email1">
                                <i class="fas fa-user-circle"></i>
                            </label>
                            <input type="hidden" id="track" name="country_code">
                            <input type="tel" class="form-control pranto-control" id="phone" name="mobile"
                                   value="{{old('mobile')}}" placeholder="@lang('Your Contact Number')" required>
                        </div>

                        <div class="form-group d-none">
                            <input type="text" name="country" id="country" value="{{old('country')}}"
                                   class="form-control">
                        </div>


                        <div class="form-group">
                            <label class="fixlabel" for="pass1">
                                <i class="fas fa-unlock"></i>
                            </label>
                            <input type="password" name="password" value="{{old('password')}}" class="form-control"
                                   placeholder="@lang('Password')">
                        </div>

                        <div class="form-group">
                            <label class="fixlabel" for="pass1">
                                <i class="fas fa-unlock"></i>
                            </label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="@lang('Retype Password')">
                        </div>


                        <div class="form-group">
                            <input type="submit" id="recaptcha" class="submit-form-btn" value="@lang('SIGN UP')">
                        </div>
                        <div class="form-group">
                            @lang("Already have an account yet?")
                            <a href="{{route('user.login')}}" class=" d-block">@lang('Sign In')</a>
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

@section('script')
    <script src="{{ asset('assets/admin/build/js/intlTelInput.js') }}"></script>

    <script>

        $('select[name=country]').val("{{ old('country') }}");
    </script>

    <script>
        $("#phone").on("countrychange", function (e, countryData) {
            // do something with countryData

            var data = $(this).val('+' + countryData.dialCode)
            $('#track').val(data);
            var country = countryData.name;
            var country = country.split('(')[0];
            $('#country').val(country);
        });
        $("#phone").intlTelInput({
            geoIpLookup: function (callback) {
                $.get("https://ipinfo.io", function () {
                }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },

            // hiddenInput: "full_number",
            initialCountry: "auto",
            utilsScript: "{{asset('assets/admin/build/js/utils.js')}}"
        });
    </script>

@endsection
