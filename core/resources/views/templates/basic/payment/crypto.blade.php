@extends(activeTemplate().'layouts.master')
@section('content')
    <div class="inner-banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="title"><span>{{__($page_title)}}</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Payment Preview')</div>
                <div class="card-body text-center">
                    <h3> @lang('PLEASE SEND EXACTLY') <span style="color: green"> {{ $data->amount }}</span> {{$data->currency}}</h3>
                    <h5>@lang('TO') <span style="color: green"> {{ $data->sendto }}</span></h5>
                    <img src="{{$data->img}}" alt="">
                    <h4 class="text-white bold">@lang('SCAN TO SEND')</h4>
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
@endsection

@section('js')

@stop
