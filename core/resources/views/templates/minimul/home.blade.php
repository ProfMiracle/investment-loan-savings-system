@extends(activeTemplate() .'layouts.master')
@section('style')

@stop

@section('content')


    <!-- ========Banner-Section Starts Here ========-->
    <section class="banner-section">
        <div class="banner-shape02"></div>
        <div class="banner-shape03"></div>
        <div class="banner-shape01">
            <img src="{{asset('assets/images/frontend/animation/banner-shape.png')}}" alt="banner">
        </div>
        <div class="circle-2" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/05.png')}}" alt="shape">
        </div>
        <div class="circle-2 three" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/11.png')}}" alt="shape">
        </div>

        <div class="circle-2 five" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/15.png')}}" alt="shape">
        </div>

        <div class="container">
            <div class="banner-area align-items-center">
                <div class="banner-content">
                    <h1 class="title">{{__($homeContent->data_values->title)}}</h1>
                    <a href="{{route('user.register')}}" class="custom-button bg-1">@lang('SIGNUP NOW')</a>
                </div>
                <div class="banner-thumb d-none d-md-block">
                    <div class="thumb">
                        <img src="{{asset('assets/images/frontend/'.$homeContent->data_values->image)}}" alt="...">
                    </div>
                    <div class="banner-coin">
                        <img src="{{asset('assets/images/frontend/'.$homeContent->data_values->coin_image)}}"
                             alt="banner">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========Banner-Section Ends Here ========-->

    <!-- ========Counter-Section Starts Here ========-->
    <div class="counter-section padding-top padding-bottom">
        <div class="container">
            <div class="counter-area">
                <div class="counter-wrapper">
                    <div class="counter-item">
                        <div class="counter-thumb bg-4">
                            <i class="flaticon-business-and-finance-2"></i>
                        </div>
                        <div class="counter-content">
                            <div class="odo-area">
                                <h3 class="odo-title">{{$general->cur_sym}}</h3>
                                <h3 class="odo-title odometer"
                                    data-odometer-final="{{$investedInPitches}}">{{$investedInPitches}}</h3>
                            </div>
                            <p>@lang('Invested in pitches')</p>
                        </div>
                    </div>
                    <div class="counter-item">
                        <div class="counter-thumb bg-1">
                            <i class="flaticon-user-1"></i>
                        </div>
                        <div class="counter-content">
                            <div class="odo-area">
                                <h3 class="odo-title odometer"
                                    data-odometer-final="{{$registerMember}}">{{$registerMember}}</h3>
                            </div>
                            <p>@lang('Registered Members')</p>
                        </div>
                    </div>
                    <div class="counter-item">
                        <div class="counter-thumb bg-3">
                            <i class="flaticon-partnership"></i>
                        </div>
                        <div class="counter-content">
                            <div class="odo-area">
                                <h3 class="odo-title">{{$general->cur_sym}}</h3>
                                <h3 class="odo-title odometer"
                                    data-odometer-final="{{$averageInvest}}">{{$averageInvest}}</h3>
                            </div>
                            <p>@lang('Average Investment')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========Counter-Section Ends Here ========-->

    <!-- ========Ticket-Section Starts Here ========-->
    <section class="ticket-section padding-bottom c-shape-wrapper">
        <div class="c-shape01" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/circle01.png')}}" alt="shapes">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="title">{{__($homeContent->data_values->plan_title)}}</h2>
                        <p>{{__($homeContent->data_values->plan_sub_title)}}</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mb-30-none">
                @php
                    $color = ['bg-1','bg-2','bg-3','bg-4','bg-5','bg-6','bg-7','bg-8'];
                @endphp

                @foreach($plans as $k => $data)
                    @php
                        $time_name = \App\TimeSetting::where('time', $data->times)->first();
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="ticket-item {{$color[$k]}}">
                            <h3 class="title">{{$data->name}}</h3>
                            <h6 class="sub-title">{{__($data->interest)}} @if($data->interest_status == 1)
                                    % @else {{__($general->cur_text)}} @endif</h6>
                            <ul>
                                <li>{{__($time_name->name)}}
                                    / @if($data->lifetime_status == 0) {{__($data->repeat_time)}} @lang('Times') @else @lang('Lifetime') @endif</li>
                                @if($data->capital_back_status == 1)

                                    <li><span class="badge badge-success">@lang('Capital Will Return Back')</span></li>
                                @elseif($data->capital_back_status == 0)
                                    <li><span class="badge badge-warning">@lang('Capital Will Store')</span></li>
                                @endif
                                <li>@lang('24/7Support')</li>


                                @if($data->fixed_amount == 0)
                                    <li class="plan_min"> @lang('Min.') {{__($general->cur_sym)}}{{__($data->minimum)}}
                                        <span>@lang('Max:') {{__($general->cur_sym)}}{{__($data->maximum)}}</span></li>

                                @else
                                    <li class="plan_min"><span>@lang('Invest Amount')
                                            : {{__($general->cur_sym)}}{{__($data->maximum)}}</span></li>

                                @endif
                            </ul>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#depoModal"
                               data-resource="{{$data}}"
                               class="custom-button custom-button-color investButton">@lang('Invest Now')</a>
                        </div>
                    </div>

                    @php
                        array_push($color, $color[$k]);
                    @endphp
                @endforeach
            </div>
        </div>
    </section>
    <!-- ========Ticket-Section Ends Here ========-->

    <!-- ========Investment-Section Starts Here ========-->
    <section class="investment-section padding-bottom pos-rel">
        <div class="star-4">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>
        <div class="star-4 three">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>
        <div class="star-4 four">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>
        <div class="star-4 five">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>
        <div class="star-4 six">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>
        <div class="star-4 seven">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>
        <div class="star-4 eight">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>


        <div class="container ">
            <div class="d-flex flex-wrap align-items-center">
                <div class="invest--area">
                    <div class="row">
                        <div class="col-12 pr-lg-5">
                            <div class="section-header">
                                <h3 class="title">{{__($homeContent->data_values->invest_title)}} </h3>
                                <p class="ml-0">{{__($homeContent->data_values->invest_sub_title)}}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="investment-area">


                                <div class="investment-item counter-item2 two">
                                    <div class="investment-thumb">
                                        <img src="{{asset('assets/images/frontend/footer/invest02.png')}}"
                                             alt="investment">
                                    </div>
                                    <div class="investment-content">
                                        <h4 class="odo-title">{{$general->cur_sym}}</h4>
                                        <h4 class="odometer"
                                            data-odometer-final="{{$totalDeposit}}">{{$totalDeposit}}</h4>
                                        <p>@lang('Total Deposited')</p>
                                    </div>
                                </div>
                                <div class="investment-item counter-item2">
                                    <div class="investment-thumb">
                                        <img src="{{asset('assets/images/frontend/footer/invest03.png')}}"
                                             alt="investment">
                                    </div>
                                    <div class="investment-content">
                                        <h4 class="odo-title">{{$general->cur_sym}}</h4>
                                        <h4 class="odometer"
                                            data-odometer-final="{{$totalWithdraw}}">{{$totalWithdraw}}</h4>
                                        <p>@lang('Total Withdraw')</p>
                                    </div>
                                </div>
                                <div class="investment-item counter-item2 one">
                                    <div class="investment-thumb">
                                        <img src="{{asset('assets/images/frontend/footer/invest04.png')}}"
                                             alt="investment">
                                    </div>
                                    <div class="investment-content">
                                        <h4 class="odo-title">{{$totalAccounts}}</h4>
                                        <p>@lang('Total Accounts')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ========Investment-Section Ends Here ========-->


    @include(activeTemplate().'partials.call-to-action')

    <!-- ========Feature-Section Starts Here ========-->
    <section class="feature-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="title">{{__($featureCaption->data_values->title)}}</h2>
                        <p>{{__($featureCaption->data_values->short_details)}}</p>
                    </div>
                </div>
            </div>
            <div class="feature-wrapper">
                <div class="feature-area two">
                    @foreach($features as $k => $data)
                        @if($k%2 == 0)
                            <div class="feature-item">
                                <h5 class="subtitle">{{__($data->data_values->title)}}</h5>
                                <p>{{__($data->data_values->short_details)}}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="feature-thumb pos-rel">
                    <img
                        src="{{get_image(config('constants.frontend.feature.path') .'/'. @$featureCaption->data_values->image)}}"
                        alt="feature">


                    <div class="coin-3">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-3 two">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-3 three">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-4">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-4 two">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-4 three">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-4 four">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>

                    <div class="coin-3 bela two">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-3 bela three">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-4 bela">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-4 bela two">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-4 bela three">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                    <div class="coin-4 bela four">
                        <img src="{{asset('assets/images/frontend/feature/feature-coin.png')}}" alt="footer">
                    </div>
                </div>
                <div class="feature-area">
                    @foreach($features as $k => $data)
                        @if($k%2 != 0)
                            <div class="feature-item">
                                <h5 class="subtitle">{{__($data->data_values->title)}}</h5>
                                <p>{{__($data->data_values->short_details)}}</p>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </section>
    <!-- ========Feature-Section Ends Here ========-->

    <!-- ========Profit-Section Stars Here ========-->
    <section class="profit-calc padding-top padding-bottom light-color bg_img"
             data-background="{{asset('assets/images/frontend/footer/')}}/profit-bg.png">
        <div class="shape"></div>
        <div class="circle-2" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/')}}/08.png" alt="shape">
        </div>
        <div class="circle-2 five" data-paroller-factor="-0.10" data-paroller-factor-lg="0.30"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/')}}/05.png" alt="shape">
        </div>
        <div class="elepsis">
            <img src="{{asset('assets/images/frontend/footer/elepsis.png')}}" alt="profit">
        </div>
        <div class="man-coin">
            <img src="{{asset('assets/images/frontend/footer/man-coin.png')}}" alt="profit">
        </div>
        <div class="coin-only">
            <img src="{{asset('assets/images/frontend/footer/profit-coin.png')}}" alt="profit">
        </div>
        <div class="man-only">
            <img src="{{asset('assets/images/frontend/footer/profit-man.png')}}" alt="profit">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="title">{{__($homeContent->data_values->profit_title)}}</h2>
                        <p>{{$homeContent->data_values->profit_sub_title}}</p>
                    </div>
                </div>
            </div>
            <form class="profit-form row justify-content-center">
                <div class="form-group col-sm-6 col-md-4 col-lg-3">
                    <h6 class="profil-title">@lang('Plan')</h6>
                    <select class="select-bar" id="changePlan">
                        <option value="">@lang('Choose Plan')</option>
                        @foreach($planList as $k => $data)
                            <option value="{{$data->id}}" >{{$data->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-6 col-md-4 col-lg-3">
                    <h6 class="profil-title">@lang('Invest Amount')</h6>
                    <input type="text" placeholder="0.00" class="invest-input"
                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                </div>
                <div class="form-group col-sm-6 col-md-4 col-lg-3">
                    <h6 class="profil-title">@lang('Profit')</h6>
                    <input type="text" placeholder="0.00" class="profit-input" readonly>
                    <code class="period"></code>
                </div>
            </form>
        </div>
    </section>
    <!-- ========Profit-Section Ends Here ========-->

    <!-- ========Feature-Section Starts Here ========-->
    <section class="get-profit-section padding-top padding-bottom pos-rel">
        <div class="circle-2" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/05.png')}}" alt="shape">
        </div>
        <div class="left-shape01 right">
            <img src="{{asset('assets/images/frontend/animation/right-shape-1.png')}}" alt="shape"
                 class="wow slideInRight">
        </div>
        <div class="circle-2 four" data-paroller-factor="-0.1" data-paroller-factor-lg="0.30"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/11.png')}}" alt="shape">
        </div>
        <div class="circle-1 three">
            <img src="{{asset('assets/images/frontend/animation/12.png')}}" alt="animation">
        </div>
        <div class="trop-3">
            <img src="{{asset('assets/images/frontend/animation/13.png')}}" alt="animation">
        </div>
        <div class="trop-4">
            <img src="{{asset('assets/images/frontend/animation/14.png')}}" alt="animation">
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="title">{{$profitCaption->data_values->title}}</h2>
                        <p>{{$profitCaption->data_values->short_details}}</p>
                    </div>
                </div>
            </div>
            <div class="get-profit">
                @foreach($profits as $k=>$data)
                    <div class="item">
                        <div class="item-thumb">
                            <img src="{{asset('assets/images/frontend/profit/'.$data->data_values->image)}}"
                                 alt="profit">
                        </div>
                        <h5 class="subtitle">{{$data->data_values->title}}</h5>
                    </div>
                @endforeach
                <div class="thumb d-none d-lg-block">
                    <img src="{{asset('assets/images/frontend/profit/'.$profitCaption->data_values->image)}}"
                         alt="profit">
                </div>
            </div>
        </div>
    </section>
    <!-- ========Feature-Section Ends Here ========-->

    <!-- ========Newslater-Section Starts Here ========-->
    <section id="subscribe" class="newslater-section pt-80 overlay-1 bg_img pos-rel" data-paroller-factor="0.10"
             data-paroller-factor-lg="-0.30"
             data-paroller-type="background" data-paroller-direction="vertical">

        <div class="star-1">
            <img src="{{asset('assets/images/frontend/animation/01.png')}}" alt="shape">
        </div>

        <div class="circle-1">
            <img src="{{asset('assets/images/frontend/animation/02.png')}}" alt="shape">
        </div>

        <div class="trop-1">
            <img src="{{asset('assets/images/frontend/animation/03.png')}}" alt="shape">
        </div>

        <div class="star-2">
            <img src="{{asset('assets/images/frontend/animation/04.png')}}" alt="shape">
        </div>

        <div class="circle-2" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/05.png')}}" alt="shape">
        </div>

        <div class="star-3">
            <img src="{{asset('assets/images/frontend/animation/06.png')}}" alt="shape">
        </div>


        <div class="container">
            <div class="newslater-wrapper ">
                <h2 class="title">@lang('Subscribe Newslater')</h2>
                <form class="subscribe-form pb-70" action="{{route('home.subscribe')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" placeholder="@lang('Email Address')">
                        <button type="submit">
                            <i class="flaticon-send"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- ========Newslater-Section Ends Here ========-->

    <!-- ========Hyip-About-Section Starts Here ========-->
    <section class="about-section padding-bottom pt-80">
        <div class="container mw-lg-100">
            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="hyip-about-thumb">
                        <img src="{{asset('assets/images/frontend/'.@$about->value->about)}}"
                             alt="{{$general->sitename}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hyip-about-content pt-80">
                        <div class="section-header left-style">
                            <h2 class="title">{{__(@$about->value->title)}}</h2>
                            <p class="ml-0">{{__(strip_tags(@$about->value->details))}}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========Hyip-About-Section Ends Here ========-->


    <!-- ========Transaction-Section Starts Here ========-->
    <section class="transaction-section bg-shape-1 padding-top padding-bottom">
        <div class="left-shape01">
            <img src="{{asset('assets/images/frontend/animation/left-shape-1.png')}}" alt="shape"
                 class="wow slideInLeft">
        </div>
        <div class="trop-2">
            <img src="{{asset('assets/images/frontend/animation/09.png')}}" alt="shape">
        </div>
        <div class="circle-2" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/05.png')}}" alt="shape">
        </div>
        <div class="circle-3" data-paroller-factor="0.10" data-paroller-factor-lg="-0.30"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/08.png')}}" alt="shape">
        </div>
        <div class="star-4">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>
        <div class="star-4 two">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>
        <div class="star-5">
            <img src="{{asset('assets/images/frontend/animation/07.png')}}" alt="shape">
        </div>
        <div class="circle-1 two">
            <img src="{{asset('assets/images/frontend/animation/10.png')}}" alt="shape">
        </div>
        <div class="circle-2 two" data-paroller-factor="-0.10" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/08.png')}}" alt="shape">
        </div>
        <div class="circle-2 three" data-paroller-factor="-0.1" data-paroller-factor-lg="0.30"
             data-paroller-type="foreground" data-paroller-direction="horizontal">
            <img src="{{asset('assets/images/frontend/animation/11.png')}}" alt="shape">
        </div>
        <div class="right-circle d-none d-lg-block"></div>
        <div class="shadow1 wow slideInUp" data-wow-duration="1s">
            <img src="{{asset('assets/images/frontend/animation/shadow1.png')}}" alt="animation">
        </div>
        <div class="shadow2 wow slideInUp" data-wow-duration="1s" data-wow-delay=".5s">
            <img src="{{asset('assets/images/frontend/animation/shadow1.png')}}" alt="animation">
        </div>
        <div class="coin1 wow bounceInDown" data-wow-duration="1s" data-wow-delay="1.5s">
            <img src="{{asset('assets/images/frontend/animation/coin1.png')}}" alt="animation">
        </div>
        <div class="coin2 wow bounceInDown" data-wow-duration="1s" data-wow-delay="2s">
            <img src="{{asset('assets/images/frontend/animation/coin2.png')}}" alt="animation">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="title">{{__($homeContent->data_values->trx_title)}}</h2>
                        <p>{{__($homeContent->data_values->trx_sub_title)}}</p>
                    </div>
                </div>
            </div>
            <div class="tab deposit-tab">
                <ul class="tab-menu text-center">
                    <li class="active custom-button">
                        @lang('Latest deposit')
                    </li>
                    <li class="custom-button">
                        @lang('Latest Withdraw')
                    </li>
                </ul>
                <div class="tab-area">
                    <div class="tab-item active">
                        <div class="deposite-table">
                            <table>
                                <thead>
                                <tr class="bg-2">
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
                                        <td>
                                            <div class="author">
                                                <div class="thumb">
                                                    <a href="javascript:void(0)">
                                                        <img
                                                            src="{{get_image(config('constants.user.profile.path').'/'.$data->user->image)}}"
                                                            alt="{{$data->user->username}}">
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <a href="javascript:void(0)">{{$data->user->fullname}} </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{date('M d, Y',strtotime($data->created_at))}}</td>
                                        <td>{{__($general->cur_sym)}} {{formatter_money($data->amount)}}</td>
                                        <td>{{__($data->gateway->name)}}</td>
                                        <td>{{diffForHumans($data->created_at)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-item">
                        <div class="deposite-table">
                            <table>
                                <thead>
                                <tr class="bg-2">
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
                                        <td>
                                            <div class="author">
                                                <div class="thumb">
                                                    <a href="javascript:void(0)">
                                                        <img
                                                            src="{{get_image(config('constants.user.profile.path').'/'.$data->user->image)}}"
                                                            alt="{{$data->user->username}}">
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <a href="javascript:void(0)">{{$data->user->fullname}} </a>
                                                </div>
                                            </div>
                                        </td>


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
    </section>
    <!-- ========Transaction-Section Ends Here ========-->


    @include(activeTemplate().'partials.client-say')


    @include(activeTemplate().'partials.section-blog')

    @include(activeTemplate().'partials.we-accept')



    <!-- Modal -->
    <div class="modal fade" id="depoModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <strong class="modal-title" id="ModalLabel">

                        @guest
                            @lang('At First Sign In your Account')
                        @else
                            @lang('Confirm to invest on') <span class="planName"></span>
                        @endguest
                    </strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="{{route('user.buy.plan')}}" method="post">
                    @csrf
                    @auth
                        <div class="modal-body">

                            <div class="form-group">
                                <h6 class="text-center investAmountRenge"></h6>

                                <p class="text-center mt-1 interestDetails"></p>
                                <p class="text-center interestValidaty"></p>

                                <div class="form-group">
                                    <strong>@lang('Select Wallet')</strong>
                                    <select class="form-control" name="wallet_type">
                                        @foreach($wallets as $k=>$data)
                                            <option value="{{$data->id}}"> {{__(str_replace('_',' ',$data->type))}}
                                                ({{formatter_money($data->balance)}} {{__($general->currency)}})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="plan_id" class="plan_id">


                                <div class="form-group">
                                    <strong>@lang('Invest Amount')</strong>
                                    <input type="text" class="form-control fixedAmount" id="fixedAmount" name="amount"
                                           value="{{old('amount')}}"
                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success ">@lang('Yes')</button>
                            <button type="button" class="btn btn-danger btn-sm"
                                    data-dismiss="modal">@lang('No')</button>
                        </div>
                    @endauth

                    @guest

                        <div class="modal-footer">
                            <a href="{{route('user.login')}}" type="button"
                               class="btn btn-success custom-success">@lang('Please, Signin your account at first')</a>
                        </div>
                    @endguest
                </form>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>

        (function ($) {
            "use strict";

            $(document).ready(function () {
                $('.investButton').on('click', function () {
                    var data = $(this).data('resource');
                    var symbol = "{{__($general->cur_sym)}}";
                    var currency = "{{__($general->cur_text)}}";

                    if (data.fixed_amount == '0') {
                        $('.investAmountRenge').text(`@lang('Invest'): ${symbol}${data.minimum} - ${symbol}${data.maximum}`);
                        $('.fixedAmount').val('');
                        $('#fixedAmount').attr('readonly', false);

                    } else {
                        $('.investAmountRenge').text(`@lang('Invest'): ${symbol}${data.fixed_amount}`);
                        $('.fixedAmount').val(data.fixed_amount);

                        $('#fixedAmount').attr('readonly', true);
                    }

                    if (data.interest_status == '1') {
                        $('.interestDetails').html(`<strong> @lang('Interest'): ${data.interest} % </strong>`);
                    } else {
                        $('.interestDetails').html(`<strong> @lang('Interest'): ${data.interest} ${currency}  </strong>`);
                    }
                    if (data.lifetime_status == '0') {
                        $('.interestValidaty').html(`<strong>  @lang('Per') ${data.times} @lang('Hours') ,  ${data.repeat_time} @lang('Times')</strong>`);
                    } else {
                        $('.interestValidaty').html(`<strong>  @lang('Per') ${data.times} @lang('Hours'),  @lang('Lifetime') </strong>`);
                    }

                    $('.planName').text(data.name);
                    $('.plan_id').val(data.id);

                });



                $("#changePlan").on('change', function () {
                    var planId =  $("#changePlan option:selected").val();
                    var investInput =  $('.invest-input').val();
                    var profitInput =  $('.profit-input').val('');

                    $('.period').text('');

                    if (investInput != '' && planId != null) {
                        ajaxPlanCalc(planId, investInput)
                    }
                });



                $(".invest-input").on('change', function () {
                    var planId = $("#changePlan option:selected").val();
                    var investInput = $(this).val();
                    var profitInput = $('.profit-input').val('');
                    $('.period').text('');
                    if (investInput != '' && planId != null) {
                        ajaxPlanCalc(planId, investInput)
                    }
                });


            });



        })(jQuery);

        function ajaxPlanCalc(planId, investInput) {

            $.ajax({
                url: "{{route('planCalculator')}}",
                type: "post",
                data: {
                    planId,
                    investInput
                },
                success: function (response) {

                    var alertStatus = "{{$general->alert}}";
                    if(response.errors){
                        if(alertStatus == '1'){
                            iziToast.error({message:response.errors, position: "topRight"});
                        }else if(alertStatus == '2'){
                            toastr.error(response.errors);
                        }
                    }

                    console.log(response);

                    $('.profit-input').val(response.interest_amount);
                    $('.period').text(response.interestValidity);


                }
            });
        }
    </script>

@stop
