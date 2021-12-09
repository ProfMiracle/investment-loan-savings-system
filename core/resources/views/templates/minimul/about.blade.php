@extends(activeTemplate() .'layouts.master')

@section('content')
    @include(activeTemplate().'partials.popup-form')
    @include(activeTemplate().'partials.frontend-breadcrumb')
    <!-- ========Feature-Section Starts Here ========-->
    <div class="feature-section padding-bottom padding-top">
        <div class="container">
            <div class="row mb-30-none justify-content-center">
                @foreach($services as $data)
                <div class="col-md-6 col-sm-10 col-lg-4">
                    <div class="feature--item">
                        <div class="header">
                            <div class="thumb">
                                <img src="{{get_image(config('constants.frontend.services.path').'/'.$data->value->image)}}" alt="{{__($data->value->title)}}">
                            </div>
                            <h5 class="title">{{__($data->value->title)}}</h5>
                        </div>
                        <div class="content">
                            <p>{{__($data->value->details)}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- ========Feature-Section Ends Here ========-->

    <!-- ========Hyip-About-Section Starts Here ========-->
    <section class="about-section padding-bottom">
        <div class="container mw-lg-100">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hyip-about-thumb">
                        <img src="{{asset('assets/images/frontend/'.@$about->value->about)}}" alt="{{$general->sitename}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hyip-about-content">
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


    @include(activeTemplate().'partials.call-to-action')

    <!-- ========Investetor-Section Starts Here ========-->
    <section class="investetor-section padding-top padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="title">{{__(@$about->value->investor_title)}}</h2>
                        <p>{{__(@$about->value->investor_details)}}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-30-none">

                @foreach($topInvestor as $k => $data)
                <div class="col-md-6 col-lg-4 col-xl-3 col-sm-10">
                    <div class="investor-item">
                        <div class="investor-thumb">


                            <img src="{{get_image(config('constants.user.profile.path') .'/'. json_decode(json_encode($data['user']['image']))) }}" alt="{{json_decode(json_encode($data['user']['username']))}}">
                            <a href="{{get_image(config('constants.user.profile.path') .'/'. json_decode(json_encode($data['user']['image']))) }}" class="img-pop">
                                <i class="flaticon-plus"></i>
                            </a>
                        </div>
                        <div class="investor-content">
                            <h5 class="title">
                                <a href="javascript:void(0)"> {{json_decode(json_encode($data['user']['username']))}}</a>
                            </h5>
                            <span class="total">@lang('Total Invest') : </span><span class="amount">{{$general->cur_sym}}{{$data['totalAmount'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ========Investetor-Section Ends Here ========-->

    <!-- ========Investetor-Section Starts Here ========-->
    <section class="statistics-section">
        <div class="container">
            <div class="row">
                <div class="section-header">
                    <h2 class="title">{{__(@$about->value->statistics_title)}}</h2>
                    <p>{{__(@$about->value->statistics_details)}}</p>
                </div>

                <div class="col-lg-12 col-xl-12">

                    <div class="chart-scroll">
                        <div class="chart-wrapper">
                            <canvas id="myChart" width="400" height="160"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========Investetor-Section Ends Here ========-->


    @include(activeTemplate().'partials.client-say')


    @include(activeTemplate().'partials.section-blog')
    @include(activeTemplate().'partials.we-accept')
@endsection

@section('load-js')
<script src="{{asset('assets/templates/minimul/js/chart.js')}}"></script>
@stop
@section('script')
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
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
