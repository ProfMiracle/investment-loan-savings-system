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

                                    @foreach($authWallets as $k=> $data)
                                    <div class="col-md-4">
                                        <div class="user-info-item @if($k%2 != 0 ) two @endif">
                                            <div class="user-info-header">
                                                <div class="left">
                                                    <p>{{__(str_replace('_',' ',strtoupper($data->type)))}}</p>
                                                    <h4 class="title">{{$general->cur_sym}}{{formatter_money($data->balance)}}</h4>
                                                </div>
                                                <div class="right">
                                                    @if($data->type == 'deposit_wallet')
                                                        <a href="{{route('user.deposit.history')}}" class="privacy-btn">
                                                            <img src="{{asset('assets/templates/minimul/images/user/withdraw.png')}}" alt="user">
                                                        </a>
                                                    @elseif($data->type == 'interest_wallet')
                                                        <a href="{{route('user.referral')}}" class="privacy-btn">
                                                            <img src="{{asset('assets/templates/minimul/images/user/withdraw.png')}}" alt="user">
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="balance-thumb">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    @foreach($savingsWallets as $k=> $data)
                                        <div class="col-md-4">
                                            <div class="user-info-item @if($k%2 != 0 ) two @endif">
                                                <div class="user-info-header">
                                                    <div class="left">
                                                        <p>{{__(str_replace('_',' ',strtoupper($data->type)))}}</p>
                                                        <h4 class="title">{{$general->cur_sym}}{{formatter_money($data->balance)}}</h4>
                                                    </div>
                                                    <div class="right">
                                                        @if($data->type == 'vault')
                                                            <a href="{{route('user.history.all')}}?type={{$data->type}}" class="privacy-btn">
                                                                <img src="{{asset('assets/templates/minimul/images/user/withdraw.png')}}" alt="user">
                                                            </a>
                                                        @elseif($data->type == 'autosave')
                                                            <a href="{{route('user.history.all')}}?type={{$data->type}}" class="privacy-btn">
                                                                <img src="{{asset('assets/templates/minimul/images/user/balance.png')}}" alt="user">
                                                            </a>
                                                        @elseif($data->type == 'targetsave')
                                                            <a href="{{route('user.history.all')}}?type={{$data->type}}" class="privacy-btn">
                                                                <img src="{{asset('assets/templates/minimul/images/user/earn.png')}}" alt="user">
                                                            </a>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="balance-thumb">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-md-4">
                                        <div class="user-info-item three">
                                            <div class="user-info-header">
                                                <div class="left">
                                                    <p>@lang('Total Invest')</p>
                                                    <h4 class="title">{{$general->cur_sym}}{{formatter_money($totalInvest)}}</h4>
                                                </div>
                                                <div class="right">
                                                    <a href="{{route('user.interest.log')}}" class="privacy-btn">
                                                    <img src="{{asset('assets/templates/minimul/images/user/balance.png')}}" alt="user">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="balance-thumb">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-60-80">
                                    <div class="col-sm-4">
                                        <div class="user-info-item three">
                                            <div class="user-info-header">
                                                <div class="left">
                                                    <p>@lang("Total Withdraw")</p>
                                                    <h4 class="title">{{$general->cur_sym}}{{formatter_money($totalWithdraw)}}</h4>
                                                </div>
                                                <div class="right">
                                                    <a href="{{route('user.withdrawLog')}}" class="privacy-btn">
                                                    <img src="{{asset('assets/templates/minimul/images/user/withdraw.png')}}" alt="user">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="balance-thumb">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="user-info-item two">
                                            <div class="user-info-header">
                                                <div class="left">
                                                    <p>@lang("Active loan")</p>
                                                    <h4 class="title">{{$general->cur_sym}}{{formatter_money($loan)}}</h4>
                                                </div>
                                                <div class="right">
                                                    <a href="{{route('user.loan.payback')}}" class="privacy-btn">
                                                        <img src="{{asset('assets/templates/minimul/images/user/withdraw.png')}}" alt="user">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="balance-thumb">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="user-info-item">
                                            <div class="user-info-header">
                                                <div class="left">
                                                    <p>@lang('Total Deposit')</p>
                                                    <h4 class="title">{{$general->cur_sym}}{{formatter_money($totalDeposit)}}</h4>
                                                </div>
                                                <div class="right">
                                                    <a href="{{route('user.deposit.history')}}" class="privacy-btn">
                                                    <img src="{{asset('assets/templates/minimul/images/user/balance.png')}}" alt="user">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="balance-thumb">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="user-info-item two">
                                            <div class="user-info-header">
                                                <div class="left">
                                                    <p>@lang('Total Ticket')</p>
                                                    <h4 class="title">{{$general->cur_sym}}{{$totalTicket}}</h4>
                                                </div>
                                                <div class="right">

                                                    <a href="{{route('user.ticket')}}" class="privacy-btn">
                                                    <img src="{{asset('assets/templates/minimul/images/user/earn.png')}}" alt="user">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="balance-thumb">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="chart">
                                    <div class="user-header">
                                        <h6 class="title">Revenue Statistics</h6>
                                    </div>
                                    <div class="chart-scroll m-0">
                                        <div class="chart-wrapper m-0">
                                            <canvas id="myCharT" width="400" height="160"></canvas>
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
    <script src="{{asset('assets/templates/minimul/js/chart.js')}}"></script>
@stop
@section('script')
    <script>
        var ctx = document.getElementById('myCharT').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($collection['day']),
                datasets: [{
                    label: '# Weekly Revenue',
                    data: @json($collection['trx']),
                    backgroundColor: [
                        'rgba(58, 248, 93, 0.26)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(58, 248, 93, 0.26)'
                    ],
                    borderColor: [
                        'rgba(58, 248, 80, 0.65)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(58, 248, 80, 0.65)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection
