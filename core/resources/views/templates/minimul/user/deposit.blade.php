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
                                <div class="row mb-60-80">
                                    <div class="col-md-12">
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div>{{$error}}</div>
                                            @endforeach
                                        @endif
                                    </div>


                                    @foreach($gatewayCurrency as $data)

                                        <div class="col-lg-3 col-md-3 mb-4">
                                            <div class="card card-deposit">
                                                <h5 class="card-header card-header-bg text-center">{{__($data->name)}}</h5>
                                                <div class="card-body card-body-deposit">
                                                    <img src="{{$data->methodImage()}}" class="card-img-top" alt="{{$data->name}}" style="width: 100%">
                                                </div>
                                                <div class="card-footer card-footer-bg">
                                                    <button type="button"  data-id="{{$data->id}}" data-resource="{{$data}}"
                                                       data-min_amount="{{formatter_money($data->min_amount, $data->method->crypto())}}"
                                                       data-max_amount="{{formatter_money($data->max_amount, $data->method->crypto())}}"
                                                       data-base_symbol="{{$data->baseSymbol()}}"
                                                       data-fix_charge="{{formatter_money($data->fixed_charge, $data->method->crypto())}}"
                                                       data-percent_charge="{{formatter_money($data->percent_charge, $data->method->crypto())}}"
                                                       class=" btn btn-custom2  deposit" data-toggle="modal" data-target="#exampleModal">
                                                        @lang('Deposit Now')</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========User-Panel-Section Ends Here ========-->



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="exampleModalLabel"></strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="{{route('user.deposit.insert')}}@if($dat){{'?savings'}}@endif" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="text-danger depositLimit"></p>
                        <p class="text-danger depositCharge"></p>
                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency" value="">
                            <input type="hidden" name="method_code" class="edit-method-code" value="">
                        </div>
                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{$dat->amount??old('amount')}}" @if($dat) {{'readonly'}} @endif>
                                <div class="input-group-prepend">
                                    <span class="input-group-text currency-addon addon-bg">{{$general->cur_text}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('load-js')
@stop


@section('script')
    <script>

        $(document).ready(function(){

            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{$general->cur_text}}";
                // var baseSymbol = $(this).data('base_symbol');
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit:') ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge:') ${fixCharge} ${baseSymbol} + ${percentCharge} %`
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${result.name}`);
                // $('.currency-addon').text(`${result.currency}`);
                $('.currency-addon').text(baseSymbol);


                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.method_code);

            });
        });
    </script>
@endsection
