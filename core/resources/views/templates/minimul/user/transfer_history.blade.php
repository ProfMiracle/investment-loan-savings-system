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
                                    <div class="col-md-12 mb-30">
                                        <div class="table-responsive table-responsive-xl table-responsive-lg table-responsive-md table-responsive-sm">
                                            <table class="table table-striped">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">@lang('Transaction ID')</th>
                                                    <th scope="col">@lang('Amount')</th>
                                                    <th scope="col">@lang('Mode')</th>
                                                    <th scope="col">@lang('Time')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($transfers) >0)
                                                    @foreach($transfers as $k=>$data)
                                                        <tr>
                                                            <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                                            <td data-label="@lang('Amount')">
                                                                <strong>{{formatter_money($data->amount)}} {{$general->cur_text}}</strong>
                                                            </td>
                                                            <td data-label="#@lang('Mode')">
                                                            @if($data->user_id == \Illuminate\Support\Facades\Auth::id())
                                                                    <span class="badge badge-secondary">Sent</span>
                                                            @else
                                                                    <span class="badge badge-primary">Received</span>
                                                            @endif
                                                            </td>
                                                            <td data-label="@lang('Time')">
                                                                <i class="fa fa-calendar"></i> {{date(' d M, Y ', strtotime($data->created_on))}}
                                                                <i class="fa fa-clock-o pl-1"></i> {{date('h:i A', strtotime($data->created_on))}}
                                                            </td>
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
        </div>
    </section>
    <!-- ========User-Panel-Section Ends Here ========-->
@endsection


@section('load-js')
@stop
@section('script')

@endsection
