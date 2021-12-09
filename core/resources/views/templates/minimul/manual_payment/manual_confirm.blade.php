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
                                <div class="row mb-60-80 justify-content-center">
                                    <div class="col-md-12">

                                        <div class="card">



                                            <div class="card-body">
                                                <form action="{{ route('user.manualDeposit.update') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        @php
                                                            $extra = $data->gateway->extra;
                                                        @endphp

                                                        <div class="col-md-12">
                                                            <p class="text-center mt-2">@lang('You have requested ') <b class="text-success">{{ formatter_money($data['amount'])  }} {{$data['method_currency']}}</b> @lang(', Please pay ') <b class="text-success">{{$data['final_amo'] .' '.$data['method_currency'] }}</b> @lang(' for successful payment')</p>
                                                            <h4 class="text-center mb-4">@lang('Please follow the instruction bellow')</h4>

                                                            <p class="my-4">@php echo  $data->gateway->description @endphp</p>
                                                            <p class="text-center mt-3 font-weight-bold">@lang('Delay:') @php echo  $extra->delay @endphp</p>

                                                        </div>



                                                        <div class="col-md-12">
                                                            <div class="form-group mt-4">
                                                                <label for="a-trans" class="font-weight-bold"> {{__($extra->verify_image)}}</label>
                                                                <input type="file" class="form-control form-control-lg" name="verify_image">
                                                            </div>
                                                        </div>

                                                        @foreach(json_decode($method->parameter) as $input)
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="a-trans" class="font-weight-bold">{{__($input)}}</label>
                                                                    <input type="text" class="form-control form-control-lg" name="ud[{{str_slug($input) }}]" placeholder="{{ $input }}">
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-custom2   btn-block mt-2 text-center">@lang('Pay Now')</button>
                                                            </div>
                                                        </div>

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
    </section>
    <!-- ========User-Panel-Section Ends Here ========-->


@endsection


@section('load-js')
@stop


@section('script')

@endsection
