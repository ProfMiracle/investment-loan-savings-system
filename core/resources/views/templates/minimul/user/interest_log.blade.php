@extends(activeTemplate() .'layouts.user')

@section('content')

    @include(activeTemplate().'partials.breadcrumb')

    <script>
        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function() {
                var distance = tms*1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML =days+"d: "+ hours + "h "+ minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "{{__('COMPLETE')}}";
                }
                tms--;
            }, 1000);
        }

    </script>


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
                                    <div class="col-md-12 mb-30">
                                        <div class="table-responsive table-responsive-xl table-responsive-lg table-responsive-md table-responsive-sm">
                                            <table class="table table-striped">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">@lang('Plan Name')</th>
                                                    <th scope="col">@lang('Payable Interest')</th>
                                                    <th scope="col">@lang('Period')</th>
                                                    <th scope="col">@lang('Received')</th>
                                                    <th scope="col">@lang('Capital Back')</th>
                                                    <th scope="col">@lang('Invest Amount')</th>
                                                    <th scope="col">@lang('Status')</th>
                                                    <th scope="col" style="width :20%">@lang('Next Payment')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($trans)==0)
                                                    <tr>
                                                        <td colspan="8" class="text-center">@lang('No Data Available')</td>
                                                    </tr>
                                                @endif

                                                @foreach($trans as $data)
                                                    <tr>
                                                        <td data-label="@lang('Plan Name')">{{__($data->plan->name)}}</td>
                                                        <td data-label="@lang('Payable Interest')">{{__($general->currency_sym)}} {{__($data->interest)}} / {{__($data->time_name)}} </td>
                                                        <td data-label="@lang('Period')">@if($data->period == '-1') <span class="badge badge-success">@lang('Life-time')</span>  @else {{__($data->period)}} @lang('Times') @endif</td>
                                                        <td data-label="@lang('Received')">  {{__($data->return_rec_time)}} @lang('Times') </td>
                                                        <td data-label="@lang('Capital Back')">@if($data->capital_status == '1') <span class="badge badge-success">@lang('Yes')</span>  @else <span class="badge badge-warning">@lang('No')</span> @endif</td>
                                                        <td data-label="@lang('Invest Amount')">  {{__($general->currency_sym)}} {{__($data->amount)}} </td>
                                                        <td data-label="@lang('Status')" style="padding-top:20px">  @if($data->status == '1')  <span class="badge badge-warning"><i class="fas fa-spinner fa-spin"></i> @lang('Running')</span>  @else <span class="badge badge-primary">@lang('Complete')</span> @endif </td>
                                                        <td data-label="@lang('Next Payment')" scope="row" class="font-weight-bold " ><p id="counter{{$data->id}}" class="demo countdown timess2 mt-1"> </p></td>

                                                    </tr>

                                                    <script>createCountDown("counter<?php echo $data->id ?>", {{\Carbon\Carbon::parse($data->next_time)->diffInSeconds()}});</script>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{$trans->links()}}
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
