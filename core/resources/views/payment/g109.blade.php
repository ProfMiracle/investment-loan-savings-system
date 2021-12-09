@extends(activeTemplate().'layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">

                <div class="card-header">Payment Preview</div>


                <div class="card-body">

                <button type="button" class="btn btn-success" id="btn-confirm" onClick="payWithRave()">Pay Now</button>

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


@endsection

@section('js')

@stop
