@extends(activeTemplate() .'layouts.master')

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <form action="{{ route('user.password.verify-code') }}" method="POST" class="login-form">
                    @csrf
                    <h2 class="text-center text-white pb-4 text-uppercase"> {{$page_title}}</h2>

                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">@lang('Verification Code'):</label>
                        <div class="col-sm-8">
                            <input type="text" name="code" id="pincode-input" class="magic-label form-control">
                        </div>
                    </div>

                    <div class="form-group row pt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-default website-color">@lang('Verify Code')</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9 col-12 text-center">
                            <div class="remember mr-5">
                                <label class="form-check-label" for="gridCheck1">
                                    <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
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
@push('style-lib')
<link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-pincode-input.css') }}"/>
<script src="{{ asset('assets/admin/js/bootstrap-pincode-input.js') }}"></script>
@endpush
@push('js')
<script>
$('#pincode-input').pincodeInput({
    inputs:6,
        placeholder:"- - - - - -",
        hidedigits:false
});
</script>   
@endpush
