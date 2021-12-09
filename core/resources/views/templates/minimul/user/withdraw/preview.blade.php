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

                                    <div class="col-lg-12 mb-4">
                                        <div class="card card-deposit">

                                            <div class="card-header card-header-bg">
                                                <h5 class="text-center text-white my-1">@lang('Current Balance') : <strong>{{ formatter_money($withdraw->wallet->balance)}}  {{ $general->cur_text }}</strong></h5>
                                            </div>

                                            <div class="card-body card-body-deposit">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="font-weight-boldl">@lang('Request Amount') : </label>

                                                            <div class="input-group">
                                                                <input type="text" value="{{formatter_money($withdraw->amount )}}" readonly  class="form-control form-control-lg" placeholder="@lang('Enter Amount')">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text ">{{$general->cur_text }} </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="font-weight-bold">@lang('Withdrawal Charge') : </label>
                                                            <div class="input-group">
                                                                <input type="text" value="{{ formatter_money($withdraw->charge) }}" readonly   class="form-control form-control-lg" placeholder="@lang('Enter Amount')">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text ">{{ $general->cur_text}} </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="font-weight-bold">@lang('You Will Get') : </label>
                                                            <div class="input-group">
                                                                <input type="text" value="{{ formatter_money($withdraw->final_amount) }}" readonly class="form-control form-control-lg" placeholder="@lang('Enter  Amount')" required>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text ">{{ $withdraw->currency }} </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">

                                                            <label class="font-weight-bold">@lang('Available Balance') : </label>
                                                            <div class="input-group">
                                                                <input type="text" value="{{formatter_money($withdraw->wallet->balance - ($withdraw->amount + $withdraw->charge))}}"  class="form-control form-control-lg" placeholder="@lang('Enter Amount')" required readonly>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text ">{{ $general->cur_text }} </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="form-group">
                                                                <label for="a-trans" class="font-weight-bold"> {{__($withdraw->method->verify_image)}}</label>
                                                                <input type="file" class="form-control form-control-lg" name="verify_image">
                                                            </div>

                                                            @foreach(json_decode($withdraw->detail) as $k=> $value)
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold"> {{str_replace('_',' ',$k)}} </label>
                                                                    <input type="text" name="{{$k}}" value="{{old($k)}}"  class="form-control form-control-lg" placeholder="" >
                                                                </div>
                                                            @endforeach

                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-custom2 mt-4 text-center btn-lg">@lang('Confirm')</button>
                                                            </div>
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
            </div>
        </div>
    </section>
    <!-- ========User-Panel-Section Ends Here ========-->

@endsection


@section('load-js')
@stop
@section('script')

@stop
