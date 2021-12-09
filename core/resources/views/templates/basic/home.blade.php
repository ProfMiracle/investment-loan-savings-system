@extends(activeTemplate() .'layouts.master')

@section('style')
    <style>
        .plan-item {
            padding-top: 10px;
            width: 406px;
        }
    </style>
@stop
@push('home-breadcrumb')
    <div class="banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="title py-5"> @php echo  __($homeContent->value->title) @endphp</h1>
                    <p class="pb-5">
                    @php echo  __($homeContent->value->details) @endphp
                    </p>
                    <a href="{{route('user.register')}}" class="btn btn-default website-color mt-1 mb-1">@lang('Registration')</a>
                </div>
                <div class="col-lg-6">
                    <div class="coin_main"><img src="{{asset('assets/images/frontend/'.$homeContent->value->image)}}" alt="..."></div>
                </div>
            </div>
        </div>
    </div>

@endpush


@section('content')




    <div class="sec-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sec"></div>
                </div>
            </div>
        </div>
    </div>


    @if(@$homeContent->value->can_see_featured == 1)

    <section class="investment-plan-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="section-title mb-5"> <span>@php echo  __($homeContent->value->featured_title) @endphp</span></h3>
                </div>

                @foreach($plans as $k => $data)
                    @php
                        $time_name = \App\TimeSetting::where('time', $data->times)->first();
                    @endphp
                    <div class="col-md-4">
                        <div class="plan-area">
                            <div class="plan-item">
                                <div class="plan_name">{{$data->name}}</div>
                                <div class="plan_day">{{__($data->interest)}} @if($data->interest_status == 1) % @else {{__($general->cur_text)}} @endif</div>
                                <div class="plan_pr">
                                    {{__($time_name->name)}} / @if($data->lifetime_status == 0) {{__($data->repeat_time)}} @lang('Times') @else @lang('Lifetime') @endif
                                </div>

                                <div>
                                    <ul>

                                        @if($data->capital_back_status == 1)

                                            <li> <span class="badge badge-success">@lang('Capital Will Return Back')</span></li>
                                        @elseif($data->capital_back_status == 0)
                                            <li> <span class="badge badge-warning">@lang('Capital Will Store')</span></li>
                                        @endif
                                        <li>@lang('24/7Support')</li>
                                    </ul>
                                </div>

                                @if($data->fixed_amount == 0)
                                    <div class="plan_min "> @lang('Min.') {{__($general->cur_sym)}}{{__($data->minimum)}} <span>@lang('Max:') {{__($general->cur_sym)}}{{__($data->maximum)}}</span></div>

                                @else
                                    <div class="plan_min "> <span class="color-transparent">&centerdot;</span> <span>@lang('Invest Amount'): {{__($general->cur_sym)}}{{__($data->maximum)}}</span></div>

                                @endif


                                <a href="#" data-toggle="modal" data-target="#depoModal" data-resource="{{$data}}"  class="btn btn-primary investButton">@lang('Invest Now')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <div class="sec-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sec"></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(@$homeContent->value->can_see_info == 1)
    <section class="program-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="section-title mb-5"><span>@php echo  __($homeContent->value->site_information) @endphp</span></h3>
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="af_line_wr">

                                <div class="af_line">
                                    <div class="left_line left"><span>*</span> <span>@lang('TOTAL ACCOUNTS')
                                        </span></div>
                                    <div class="right_line right">{{$totalAccounts}}</div>
                                </div>

                                <div class="af_line">
                                    <div class="left_line left"><span>*</span> <span>@lang('TOTAL DEPOSITS')</span></div>
                                    <div class="right_line right">{{$general->cur_sym}}{{formatter_money($totalDeposit)}}</div>
                                </div>

                                <div class="af_line">
                                    <div class="left_line left"><span>*</span> <span>@lang('TOTAL WITHDRAW')</span></div>
                                    <div class="right_line right">{{$general->cur_sym}}{{formatter_money($totalWithdraw)}}</div>
                                </div>

                                <div class="af_line">
                                    <div class="left_line left"><span>*</span> <span>@lang('RUNNING DATE')</span></div>
                                    <div class="right_line right">{{date('Y-d-m')}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <img src="{{asset('assets/images/frontend/'.$homeContent->value->dragon)}}" alt="Map" class="left drac"></div>
                    </div>
                    <div class="col-lg-12 text-center"><a href="{{route('user.register')}}" class="btn btn-default website-color">@lang('Become a partner')</a></div>
                </div>
            </div>
        </div>
    </section>


    <div class="sec-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sec"></div>
                </div>
            </div>
        </div>
    </div>
    @endif


    @if(@$homeContent->value->can_see_trx == 1)

    <div class="transaction">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8">
                    <h3 class="section-title"> <span>@php echo  __($homeContent->value->transaction_title) @endphp</span></h3>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="transaction-area">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#deposit" role="tab"
                                   aria-selected="true">Deposit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#withdraw" role="tab"
                                   aria-selected="false">Withdraw</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="deposit" role="tabpanel" aria-labelledby="home-tab">

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('Name')</th>
                                        <th scope="col">@lang('Date')</th>
                                        <th scope="col">@lang('Amount')</th>
                                        <th scope="col">@lang('Currency')</th>
                                        <th scope="col">@lang('Deposit')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($latestDeposit as $data)
                                    <tr>
                                        <th scope="row" class="d-flex">
                                            <div class="user-img">
                                                <img src="{{get_image(config('constants.user.profile.path').'/'.$data->user->image)}}" alt="">
                                            </div>
                                            <span>{{$data->user->fullname}}  </span>
                                        </th>
                                        <td>{{date('M d, Y',strtotime($data->created_at))}}</td>
                                        <td>{{__($general->cur_sym)}} {{formatter_money($data->amount)}}</td>
                                        <td>{{__($data->gateway->name)}}</td>
                                        <td>{{diffForHumans($data->created_at)}}</td>
                                    </tr>
                                    @endforeach


                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="profile-tab">

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('Name')</th>
                                        <th scope="col">@lang('Date')</th>
                                        <th scope="col">@lang('Amount')</th>
                                        <th scope="col">@lang('Currency')</th>
                                        <th scope="col">@lang('Withdraw')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($latestWithdraw as $data)
                                    <tr>
                                        <th scope="row" class="d-flex">
                                            <div class="user-img">
                                                <img src="{{get_image(config('constants.user.profile.path').'/'.$data->user->image)}}" alt="">
                                            </div>
                                            <span>{{$data->user->fullname}}  </span>
                                        </th>
                                        <td>{{date('M d, Y',strtotime($data->created_at))}}</td>
                                        <td>{{__($general->cur_sym)}} {{formatter_money($data->amount)}}</td>
                                        <td>{{__($data->method->name)}}</td>
                                        <td>{{diffForHumans($data->created_at)}}</td>
                                    </tr>
                                    @endforeach


                                    </tbody>
                                </table>

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
    @endif


    @if(@$homeContent->value->can_see_map == 1)
    <div class="map-area text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="map_wr"><img src="{{asset('assets/images/frontend/'.$homeContent->value->map)}}" alt="Map"></div>
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
    @endif


    <!-- Modal -->
    <div class="modal fade" id="depoModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">@lang('Confirm to invest on') <strong class="planName text-white"></strong></h5>
                </div>
                <form action="{{route('user.buy.plan')}}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <h3 class="text-center investAmountRenge"></h3>

                            <p class="text-center interestDetails"></p>
                            <p class="text-center interestValidaty"></p>

                            <div class="form-group">
                                <strong>@lang('Select Wallet')</strong>
                                <select class="form-control"  name="wallet_type">
                                    @foreach($wallets as $k=>$data)
                                        <option value="{{$data->id}}"> {{__(str_replace('_',' ',$data->type))}} ({{formatter_money($data->balance)}} {{__($general->currency)}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="plan_id" class="plan_id">


                            <div class="form-group">
                                <strong>@lang('Invest Amount')</strong>
                                <input type="text" class="form-control fixedAmount" id="fixedAmount" name="amount" value="{{old('amount')}}" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                            </div>
                        </div>
                    </div>
                    @auth
                        <div class="modal-footer">
                            <button type="submit"  class="btn btn-success " >@lang('Yes')</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">@lang('No')</button>
                        </div>
                    @endauth

                    @guest
                        <div class="modal-footer">
                            <a href="{{route('user.login')}}" type="button" class="btn btn-success custom-success" >@lang('Please, Signin your account at first')</a>
                        </div>
                    @endguest
                </form>
            </div>
        </div>
    </div>




    @if(@$homeContent->value->subscription_form == 1)
    @include(activeTemplate().'partials.subscribe')
    @endif

    @if(@$homeContent->value->we_accept == 1)
    @include(activeTemplate().'partials.we-accept')
    @endif

@endsection




@section('script')
    <script>
        $(document).ready(function () {
            $('.investButton').on('click', function () {
                var data =$(this).data('resource');
                var symbol = "{{__($general->cur_sym)}}";
                var currency = "{{__($general->cur_text)}}";

                if(data.fixed_amount == '0'){
                    $('.investAmountRenge').text(`@lang('Invest'): ${symbol}${data.minimum} - ${symbol}${data.maximum}`);
                    $('.fixedAmount').val('');
                    $('#fixedAmount').attr('readonly', false);

                }else{
                    $('.investAmountRenge').text(`@lang('Invest'): ${symbol}${data.fixed_amount}`);
                    $('.fixedAmount').val(data.fixed_amount);

                    $('#fixedAmount').attr('readonly', true);
                }

                if(data.interest_status == '1'){
                    $('.interestDetails').html(`<strong> @lang('Interest'): ${data.interest} % </strong>`);
                }else{
                    $('.interestDetails').html(`<strong> @lang('Interest'): ${data.interest} ${currency}  </strong>`);
                }
                if(data.lifetime_status == '0'){
                    $('.interestValidaty').html(`<strong>  @lang('Per') ${data.times} @lang('Hours') ,  ${data.repeat_time} @lang('Times')</strong>`);
                }else{
                    $('.interestValidaty').html(`<strong>  @lang('Per') ${data.times} @lang('Hours'),  @lang('Lifetime') </strong>`);
                }

                $('.planName').text(data.name);
                $('.plan_id').val(data.id);

            })
        })

    </script>



@endsection
