@extends(activeTemplate() .'layouts.user')

@section('style')

@stop
@section('content')


    @include(activeTemplate().'partials.breadcrumb')
    <!-- ========User-Panel-Section Starte Here ========-->
    <section class="user-panel-section padding-bottom padding-top">
        <div class="container user-panel-container">
            <div class=" user-panel-tab">
                <div class="row">
                    @include(activeTemplate().'partials.sidebar')

                    <div class="col-lg-9" id="myvideo">
                        <div class="user-panel-header mb-60-80">
                            <div class="left d-sm-block d-none">
                                <h6 class="title">{{__($page_title)}}</h6>
                            </div>
                            <ul class="right">
                                <li>
                                    <a href="#0" id="fullScreen"><i class="flaticon-ui-2"></i></a>
                                    <a href="#0" id="exitScreen"><i class="flaticon-ui-1"></i></a>
                                </li>

                                <li>
                                    <a href="#0" class="log-out d-lg-none">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                                data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                                aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>

                                            <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div>


                        <div class="tab-area fullscreen-width">
                            <div class="tab-item active">
                                <div class="row mb-60-80 justify-content-center">
                                    <div class="row">
                                        <div class="col-md-4">

                                            <img src="{{$deposit->gateway_currency()->methodImage()}}"
                                                 class="card-img-top" alt=".." style="width: 100%">
                                        </div>
                                        <div class="col-md-8">
                                            <h5>@lang('Please Pay') {{formatter_money($deposit->final_amo)}} {{$deposit->method_currency}}</h5>
                                            <h5 class="my-3">@lang('To Get') {{formatter_money($deposit->amount)}}  {{$deposit->method_currency}}</h5>

                                            <button type="button" class=" mt-4 btn-custom2 " id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>

                                            <script
                                                src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
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
                                                        onclose: function () {
                                                        },
                                                        callback: function (response) {
                                                            var txref = response.tx.txRef;
                                                            var status = response.tx.status;
                                                            var chargeResponse = response.tx.chargeResponseCode;
                                                            if (chargeResponse == "00" || chargeResponse == "0") {
                                                                window.location = '{{ url('ipn/g109') }}/' + txref + '/' + status;
                                                            } else {
                                                                window.location = '{{ url('ipn/g109') }}/' + txref + '/' + status;
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
            </div>
        </div>
    </section>
    <!-- ========User-Panel-Section Ends Here ========-->


@endsection


@section('load-js')
@stop


@section('script')

@endsection
