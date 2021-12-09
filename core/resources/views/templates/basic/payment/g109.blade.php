@extends(activeTemplate().'layouts.master')

@section('content')

    <div class="inner-banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="title"><span>@lang('Payment Preview')</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="privacy-area mb-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">


                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">

                                <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top" alt=".." style="width: 100%">
                            </div>
                            <div class="col-md-8 text-center">
                                <h3 class="mt-4">@lang('Please Pay') {{formatter_money($deposit->final_amo)}} {{$deposit->method_currency}}</h3>
                                <h3 class="my-3">@lang('To Get') {{formatter_money($deposit->amount)}}  {{$deposit->method_currency}}</h3>

                                <button type="button" class=" mt-4 btn-success btn-round custom-success text-center btn-lg" id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>


                                <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                                <script>
                                    var btn = document.querySelector("#btn-confirm");
                                    btn.setAttribute("type", "button");
                                    const API_publicKey = "{{$data->API_publicKey}}";
                                    function payWithRave() {
                                        var x = getpaidSetup({
                                            PBFPubKey: API_publicKey,
                                            customer_email: "{{$data->customer_email}}",
                                            amount: "{{$data->amount }}",
                                            customer_phone: "{{$data->customer_phone}}",
                                            currency: "{{$data->currency}}",
                                            txref: "{{$data->txref}}",
                                            onclose: function() {},
                                            callback: function(response) {
                                                var txref = response.tx.txRef;
                                                var status = response.tx.status;
                                                var chargeResponse = response.tx.chargeResponseCode;
                                                if (chargeResponse == "00" || chargeResponse == "0") {
                                                    window.location = '{{ url('ipn/g109') }}/' + txref +'/'+status;
                                                } else {
                                                    window.location = '{{ url('ipn/g109') }}/' + txref+'/'+status;
                                                }
                                                // x.close(); // use this to close the modal immediately after payment.
                                            }
                                        });
                                    }
                                </script>


                            </div>
                        </div>


                    </div>


                </div>
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

@section('script')

@stop
