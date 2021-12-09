@extends(activeTemplate() .'layouts.user')

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


    <div class="privacy-area pb-130">
        <div class="container">
            <div class="row mb-30-none">
                <div class="col-md-12 mb-30">
                    <div class="table-responsive table-responsive-xl table-responsive-lg table-responsive-md table-responsive-sm">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">@lang('Transaction ID')</th>
                                <th scope="col">@lang('Gateway')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($deposits) >0)
                                @foreach($deposits as $k=>$data)
                                    <tr>
                                        <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                        <td data-label="@lang('Gateway')">{{ $data->gateway->name   }}</td>
                                        <td data-label="@lang('Amount')">
                                            <strong>{{formatter_money($data->amount)}} {{$general->cur_text}}</strong>
                                        </td>
                                        <td data-label="@lang('Time')">
                                            <i class="fa fa-calendar"></i> {{date(' d M, Y ', strtotime($data->created_at))}}
                                            <i class="fa fa-clock-o pl-1"></i> {{date('h:i A', strtotime($data->created_at))}}
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

                    {{$deposits->links()}}
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


@section('script')

@endsection
