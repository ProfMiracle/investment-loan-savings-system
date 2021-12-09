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
                                    <div class="col-md-8">

                                        <div class="card card-deposit">
                                            <div class="card-body card-body-deposit">


                                                <div class="card-wrapper"></div>
                                                <br><br>

                                                <form role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                                                    {{csrf_field()}}
                                                    <input type="hidden" value="{{$data->track}}" name="track">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="name">@lang('CARD NAME')</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-lg custom-input" name="name"
                                                                       placeholder="@lang('Card Name')" autocomplete="off" autofocus/>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text addon-bg"><i class="fa fa-font"></i></span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="cardNumber">@lang('CARD NUMBER')</label>
                                                            <div class="input-group">
                                                                <input type="tel" class="form-control form-control-lg custom-input"
                                                                       name="cardNumber" placeholder="Valid Card Number" autocomplete="off"
                                                                       required autofocus/>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text addon-bg"><i class="fa fa-credit-card"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-4">
                                                        <div class="col-md-6">
                                                            <label for="cardExpiry">@lang('EXPIRATION DATE')</label>
                                                            <input type="tel" class="form-control form-control-lg input-sz custom-input"
                                                                   name="cardExpiry" placeholder="MM / YYYY" autocomplete="off" required/>
                                                        </div>
                                                        <div class="col-md-6 ">

                                                            <label for="cardCVC">@lang('CVC CODE')</label>
                                                            <input type="tel" class="form-control form-control-lg input-sz custom-input"
                                                                   name="cardCVC" placeholder="CVC" autocomplete="off" required/>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button class="btn btn-custom2 btn-lg btn-block text-center" type="submit"> @lang('PAY NOW')
                                                    </button>

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
        </div>
    </section>
    <!-- ========User-Panel-Section Ends Here ========-->


@endsection


@section('load-js')
@stop


@section('script')
    <script type="text/javascript" src="https://rawgit.com/jessepollak/card/master/dist/card.js"></script>

    <script>
        (function ($) {
            $(document).ready(function () {
                var card = new Card({
                    form: '#payment-form',
                    container: '.card-wrapper',
                    formSelectors: {
                        numberInput: 'input[name="cardNumber"]',
                        expiryInput: 'input[name="cardExpiry"]',
                        cvcInput: 'input[name="cardCVC"]',
                        nameInput: 'input[name="name"]'
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
