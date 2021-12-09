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
                        <div class="col-lg-offset-7 text-right" style="display: block">
                            <div style="max-width: 15%; float: right">
                                <a class="btn btn-secondary" href="{{route('user.loan.payback')}}"><i class="fa fa-fw fa-plus"></i>Payback Now</a>
                            </div>
                        </div>
                        <br>
                        <br>
                        {{--<div class="clearfix"></div>--}}

                        <div class="tab-area fullscreen-width">
                            <div class="tab-item active">


                                <div class="row mb-60-80">
                                    <div class="col-md-12 mb-30">
                                        <div class="table-responsive table-responsive-xl table-responsive-lg table-responsive-md table-responsive-sm">
                                            <table class="table table-striped">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">@lang('Loan ID')</th>
                                                    <th scope="col">@lang('Requested Amount')</th>
                                                    <th scope="col">@lang('Request Date')</th>
                                                    <th scope="col">@lang('Status')</th>
                                                    <th scope="col">@lang('Approved Date')</th>
                                                    <th scope="col">@lang('Approved Amount')</th>
                                                    <th scope="col">@lang('Payback Amount')</th>
                                                    <th scope="col">@lang('Payback Date')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($loans) >0)
                                                    @foreach($loans as $k=>$data)
                                                        <tr>
                                                            <td data-label="#@lang('Trx')">{{$data->loan_id}}</td>
                                                            <td data-label="@lang('Request Amount')">
                                                                <strong>{{formatter_money($data->request_amount)}} {{$general->cur_text}}</strong>
                                                            </td>
                                                            <td data-label="@lang('Request Date')">
                                                                <i class="fa fa-calendar"></i> {{date(' d M, Y ', strtotime($data->request_date))}}
                                                                <i class="fa fa-clock-o pl-1"></i> {{date('h:i A', strtotime($data->request_date))}}
                                                            </td>
                                                            <td data-label="#@lang('Status')">
                                                                @if($data->status == 0)
                                                                    <span class="badge badge-dark">Pending approval</span>
                                                                @elseif($data->status == 2)
                                                                    <span class="badge badge-danger">Not approved</span>
                                                                @elseif($data->status == 3)
                                                                    <span class="badge badge-success">Paid in full</span>
                                                                @else
                                                                    <span class="badge badge-primary">Approved</span>
                                                                @endif
                                                            </td>
                                                            @if($data->approved_date != null)
                                                                <td data-label="@lang('Approved Date')">
                                                                    <i class="fa fa-calendar"></i> {{date(' d M, Y ', strtotime($data->approved_date))}}
                                                                    <i class="fa fa-clock-o pl-1"></i> {{date('h:i A', strtotime($data->approved_date))}}
                                                                </td>
                                                            @else
                                                                <td data-label="#@lang('Approved date')">{{'--'}}</td>
                                                            @endif

                                                            @if($data->approved_amount != null)
                                                                <td data-label="@lang('Approved Amount')">
                                                                    <strong>{{formatter_money($data->approved_amount)}} {{$general->cur_text}}</strong>
                                                                </td>
                                                            @else
                                                                <td data-label="#@lang('Approved Amount')">{{'--'}}</td>
                                                            @endif
                                                            <td data-label="@lang('Payback Amount')">
                                                                <strong>{{formatter_money($data->payback_amount)}} {{$general->cur_text}}</strong>
                                                            </td>
                                                            @if($data->payback_date != null)
                                                                <td data-label="@lang('Payback date')">
                                                                    <i class="fa fa-calendar"></i> {{date(' d M, Y ', strtotime($data->payback_date))}}
                                                                    <i class="fa fa-clock-o pl-1"></i> {{date('h:i A', strtotime($data->payback_date))}}
                                                                </td>
                                                            @else
                                                                <td data-label="#@lang('Payback date')">{{'--'}}</td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4"> @lang('No results found')!</td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    <div>
                                     @php
                                     echo $pagination->view();
                                     @endphp
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
