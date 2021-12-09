@extends(activeTemplate() .'layouts.user')

@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop

@section('style')
    <link rel="stylesheet" href="{{asset('assets/admin/build/css/intlTelInput.css')}}">
    <style>
        .intl-tel-input {
            position: relative;
            display: inline-block;
            width: 100%;!important;
        }
    </style>
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
            <div class="col-lg-10 mx-auto">
                <form class="contact-form" action="" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="InputFirstname" class="col-form-label">@lang('First Name:')</label>
                            <input type="text" class="form-control" id="InputFirstname" name="firstname"
                                       placeholder="@lang('First Name')" value="{{$user->firstname}}" >
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="lastname" class="col-form-label">@lang('Last Name:')</label>
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                       placeholder="@lang('Last Name')" value="{{$user->lastname}}">
                        </div>

                    </div>


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="email" class="col-form-label">@lang('E-mail Address:')</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="@lang('E-mail Address')" value="{{$user->email}}" required="">
                        </div>

                        <div class="form-group col-sm-6">
                            <input type="hidden" id="track" name="country_code">
                            <label for="phone" class="col-form-label">@lang('Mobile Number')</label>
                            <input type="tel" class="form-control pranto-control" id="phone" name="mobile" value="{{$user->mobile}}" placeholder="@lang('Your Contact Number')" required>
                        </div>
                        <input type="hidden" name="country" id="country" class="form-control d-none" value="{{$user->address->country}}">
                    </div>



                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="address" class="col-form-label">@lang('Address:')</label>
                            <input type="text" class="form-control" id="address" name="address"
                                   placeholder="@lang('Address')" value="{{$user->address->address}}" required="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="state" class="col-form-label">@lang('State:')</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="@lang('state')" value="{{$user->address->state}}" required="">
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="zip" class="col-form-label">@lang('Zip Code:')</label>
                            <input type="text" class="form-control" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{$user->address->zip}}" required="">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="city" class="col-form-label">@lang('City:')</label>
                            <input type="text" class="form-control" id="city" name="city"
                                   placeholder="@lang('City')" value="{{$user->address->city}}" required="">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="fileinput fileinput-new " data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
                                         data-trigger="fileinput">
                                        <img  src="{{ get_image(config('constants.user.profile.path') .'/'. $user->image) }}" alt="...">

                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px"></div>

                                    <div class="img-input-div">
                                        <span class="btn btn-info btn-file">
                                            <span class="fileinput-new "> @lang('Select image')</span>
                                            <span class="fileinput-exists"> @lang('Change')</span>
                                            <input type="file" name="image" accept="image/*">
                                        </span>
                                        <a href="#" class="btn btn-danger fileinput-exists"
                                           data-dismiss="fileinput"> @lang('Remove')</a>
                                    </div>

                                    <code>@lang('Image size 800*800')</code>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row pt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-danger">@lang('Update Profile')</button>
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



@section('import-js')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@endsection


@section('script')
    <script src="{{ asset('assets/admin/build/js/intlTelInput.js') }}"></script>

    <script>
        $('select[name=country]').val("{{ old('country') }}");


        $("#phone").on("countrychange", function(e, countryData) {
            // do something with countryData

            var data =  $(this).val('+' + countryData.dialCode)
            $('#track').val(data);
            var country = countryData.name;
            var country = country.split('(')[0];
            $('#country').val(country);
        });
        $("#phone").intlTelInput({
            geoIpLookup: function(callback) {
                $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
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
