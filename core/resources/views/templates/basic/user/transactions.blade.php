@extends(activeTemplate().'layouts.master')

@section('content')




    <div class="inner-banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="title"><span>{{__($page_title)}}</span></h3>
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
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Remaining Balance')</th>
                                <th scope="col">@lang('Details')</th>
                                <th scope="col">@lang('Date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($logs) >0)
                                @foreach($logs as $k=>$data)
                                    <tr>
                                        <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                        <td data-label="@lang('Amount')">
                                            <strong @if($data->type == '+') class="text-success" @else class="text-danger" @endif> {{($data->type == '+') ? '+':'-'}} {{formatter_money($data->amount)}} {{$general->cur_text}}</strong>
                                        </td>
                                        <td data-label="@lang('Remaining Balance')">
                                            <strong class="text-info">{{formatter_money($data->main_amo)}} {{$general->cur_text}}</strong>
                                        </td>
                                        <td data-label="@lang('Details')">{{$data->title}}</td>
                                        <td data-label="@lang('Date')">{{date('d M, Y', strtotime($data->created_at))}}</td>
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

                    {{$logs->links()}}
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



@stop


@section('js')


@stop
