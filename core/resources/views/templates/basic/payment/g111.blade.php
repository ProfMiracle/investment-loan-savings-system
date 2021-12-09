@extends(activeTemplate().'layouts.master')

@section('css')

    <script src="https://js.stripe.com/v3/"></script>
@stop
@section('content')

    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .card button {
             padding-left: 0px !important;
        }
    </style>


    <div class="inner-banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="title"><span>@lang('Stripe Payment')</span></h2>
                </div>
            </div>
        </div>
    </div>




    <div class="privacy-area mb-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">

                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top" alt=".." style="width: 100%">
                            </div>
                            <div class="col-md-8">
                                <form action="{{$data->url}}" method="{{$data->method}}">
                                    <h3 class="text-center">@lang('Please Pay') {{formatter_money($deposit->final_amo)}} {{$deposit->method_currency}}</h3>
                                    <h3 class="my-3 text-center">@lang('To Get') {{formatter_money($deposit->amount)}}  {{$deposit->method_currency}}</h3>
                                        <script
                                            src="{{$data->src}}"
                                            class="stripe-button"
                                            @foreach($data->val as $key=> $value)
                                            data-{{$key}}="{{$value}}"
                                            @endforeach
                                        >
                                        </script>
                                </form>
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

    <script>
        $(document).ready(function () {
            $('button[type="submit"]').addClass("ml-4 mt-4 btn-success btn-round custom-success text-center btn-lg");
        })
    </script>
@stop


