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
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

                                            <img src="{{$data->gateway_currency()->methodImage()}}" class="card-img-top" alt=".." style="width: 100%">
                                        </div>
                                        <div class="col-md-8">
                                            <form action="{{ route('ipn.g107') }}" method="POST" class="text-center">
                                                @csrf
                                                <script src="//js.paystack.co/v1/inline.js"></script>
                                                <h5>@lang('Please Pay') {{formatter_money($data->final_amo)}} {{$data->method_currency}}</h5>
                                                {{--<h5 class="my-3">@lang('To Get') {{formatter_money($data->amount)}}  {{$data->method_currency}}</h5>--}}


                                                <button type="button" class=" mt-4 btn-custom2 text-center btn-lg" id="btn-confirm" onclick="payWithPaystack()">@lang('Pay Now')</button>


                                                {{--<script id="card"
                                                    src="//js.paystack.co/v1/inline.js"
                                                    data-key="{{ $send['key'] }}"
                                                    data-email="{{ $send['email'] }}"
                                                    data-amount="{{$send['amount']}}"
                                                    data-currency="{{$send['currency']}}"
                                                    data-ref="{{ $send['ref'] }}"
                                                    data-channels='{{json_encode(["card", "bank"])}}'
                                                    data-custom-button="btn-confirm"
                                                >
                                                </script>--}}
                                                <script>
                                                    function payWithPaystack(){
                                                        var handler = PaystackPop.setup({
                                                            key: '{{ $send['key'] }}',
                                                            email: '{{ $send['email'] }}',
                                                            amount: {{ $send['amount'] }},
                                                            currency: '{{ $send['currency'] }}',
                                                            ref: '{{ $send['ref'] }}',
                                                            @if($send['is_card'])
                                                            channels: ['card'],
                                                            @endif
                                                            callback: function(response){
                                                                $.ajax({
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                    },
                                                                    url: "{{ route('verifypay') }}",
                                                                    type: "post",
                                                                    data: response,
                                                                    success: function (res) {
                                                                        //console.log(res)
                                                                        window.location.href = '{{route('home.savings')}}';
                                                                    },
                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                        //console.log(textStatus, errorThrown);
                                                                        window.location.href = '{{route('home.savings')}}';
                                                                    }
                                                                });
                                                            },
                                                        });
                                                        handler.openIframe();
                                                    }
                                                </script>
                                            </form>

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
