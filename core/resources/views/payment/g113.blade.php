@extends(activeTemplate().'layouts.user')

@section('content')


    <!--Dashboard area-->
    <section class="section-padding gray-bg blog-area">
        <div class="container">
            <div class="row dashboard-content">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="dashboard-inner-content">

                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-md-10 mb-4">

                                <div class="card ">

                                    <div class="card-header text-center">@lang('2checkout Payment')</div>

                                    <div class="card-body">

                                        <form  id="myCCForm" method="{{$data->method}}" action="{{$data->url}}">
                                            {{csrf_field()}}
                                            <input name="token" type="hidden" value="" />
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <label for="cardNumber">@lang('CARD NUMBER')</label>
                                                    <div class="form-group">
                                                        <input id="ccNo" type="text" value="" autocomplete="off" required placeholder="Card Number"/>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row mt-4">

                                                <div class="col-md-6">
                                                    <label for="cardNumber">@lang('Expiration Date (MM/YYYY)')</label>
                                                    <div class="form-group">
                                                        <input id="expMonth" type="text" size="2" value="" required placeholder="MM" style="width: 30%"/>
                                                        <span> / </span>
                                                        <input id="expYear" type="text" size="4" value="" placeholder="YYYY" required style="width: 50%"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 ">
                                                    <label for="cardCVC">@lang('CVC CODE')</label>
                                                    <input id="cvv" type="text" value="" placeholder="CVC" autocomplete="off" required />
                                                </div>

                                                <div class="col-md-12 ">
                                                    <button class="custom-btn  btn-lg btn-block" type="button" id="ssbb"> @lang('PAY NOW')</button>
                                                </div>

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
    </section><!--/Dashboard area-->





@endsection

@section('script')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>


    @if($general->alert == 1)
        <script src="{{ asset('assets/admin/js/iziToast.min.js') }}"></script>
    @elseif($general->alert == 2)
        <script src="{{ asset('assets/admin/js/toastr.min.js') }}"></script>
    @endif


    <script>

        // Called when token created successfully.
        var successCallback = function(data) {
            var myForm = document.getElementById('myCCForm');

            // Set the token as the value for the token input
            myForm.token.value = data.response.token.token;

            // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
            myForm.submit();
        };

        // Called when token creation fails.
        var errorCallback = function(data) {
            // alert(data.errorCode);
            if (data.errorCode === 200) {
                tokenRequest();

            } else {

                var myAlert = "{{$general->alert}}";

                if(myAlert == 1){
                    iziToast.error({message:data.errorMsg, position: "topRight"});
                }else if(myAlert == 2){
                    toastr.error(data.errorMsg);
                }




            }
        };

        var tokenRequest = function() {
            // Setup token request arguments
            var args = {
                sellerId: "<?php echo $data->sellerID; ?>",
                publishableKey: "<?php echo $data->public_key; ?>",
                ccNo: $("#ccNo").val(),
                cvv: $("#cvv").val(),
                expMonth: $("#expMonth").val(),
                expYear: $("#expYear").val()
            };

            // Make the token request
            TCO.requestToken(successCallback, errorCallback, args);
        };

        $(function() {
            // Pull in the public encryption key for our environment
            TCO.loadPubKey('sandbox');

            // $("#myCCForm").submit(function(e) {
            $("#ssbb").click(function(e) {
                // Call our token request function
                tokenRequest();

                // Prevent form from submitting
                return false;
            });
        });
    </script>
@stop


