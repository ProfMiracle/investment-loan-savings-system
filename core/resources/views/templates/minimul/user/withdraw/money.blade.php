@extends(activeTemplate() .'layouts.user')

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


                                <div class="row mb-60-80">
                                    <div class="col-md-12 mb-30">
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div>{{$error}}</div>
                                            @endforeach
                                        @endif
                                    </div>

                                    @foreach($withdrawMethod as $data)

                                        <div class="col-lg-4 col-md-4 mb-4">
                                            <div class="card card-deposit">
                                                <h5 class="card-header card-header-bg text-center">{{__($data->name)}}</h5>
                                                <div class="card-body card-body-deposit text-center">
                                                    <img
                                                        src="{{get_image(config('constants.withdraw.method.path').'/'. $data->image)}}"
                                                        class="card-img-top" alt="{{$data->name}}" style="width: 70%">

                                                    <ul class="list-group text-center mt-1">
                                                        <li class="list-group-item">@lang('Limit')
                                                            : {{formatter_money($data->min_limit)}}
                                                            - {{formatter_money($data->max_limit)}} {{__($data->currency)}}</li>

                                                        <li class="list-group-item"> @lang('Charge')
                                                            - {{formatter_money($data->fixed_charge)}} {{__($data->currency)}}
                                                            + {{formatter_money($data->percent_charge)}}%
                                                        </li>
                                                        <li class="list-group-item">@lang('Processing Time')
                                                            - {{$data->delay}}</li>
                                                    </ul>

                                                </div>
                                                <div class="card-footer card-footer-bg">
                                                    <a href="javascript:void(0)" data-id="{{$data->id}}"
                                                       data-resource="{{$data}}"
                                                       data-min_amount="{{formatter_money($data->min_limit)}}"
                                                       data-max_amount="{{formatter_money($data->max_limit)}}"
                                                       data-fix_charge="{{formatter_money($data->fixed_charge)}}"
                                                       data-percent_charge="{{formatter_money($data->percent_charge)}}"
                                                       data-base_symbol="{{$data->currency}}"
                                                       class="btn  btn-custom2 btn-block deposit" data-toggle="modal"
                                                       data-target="#exampleModal">
                                                        @lang('Withdraw Now')</a>
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



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="exampleModalLabel">Modal title</strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="{{route('user.withdraw.moneyReq')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="text-danger depositLimit"></p>
                        <p class="text-danger depositCharge"></p>

                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency form-control" value="">
                            <input type="hidden" name="method_code" class="edit-method-code  form-control" value="">
                        </div>


                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount"
                                       placeholder="0.00" required="" value="{{old('amount')}}">

                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text addon-bg currency-addon">{{__($general->cur_text)}}</span>
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

        $(document).ready(function () {
            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = $(this).data('base_symbol');
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var selectedCurr = $("#currency_id").find(':selected').data('select_currency');
                $('.currency-addon').text(`${baseSymbol}`);


                var depositLimit = `@lang('Withdraw Limit:') ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge:') ${fixCharge} ${baseSymbol} + ${percentCharge} %`
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${result.name}`);


                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });
        });
    </script>
@stop
