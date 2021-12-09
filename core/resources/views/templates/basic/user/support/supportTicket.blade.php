@extends(activeTemplate().'layouts.user')
@section('title','')
@section('content')
    <div class="inner-banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="title"><span class="float-left">{{__($page_title)}}</span>

                    <a href="{{route('user.ticket.open') }}" class="btn btn-rounded btn-success float-right">@lang('Open New Support Ticket')</a>
                    </h2>
                </div>

            </div>
        </div>
    </div>

    <div class="privacy-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="dashboard-inner-content">


                                    <div class="card">

                                        <div class="card-body">

                                            <div class="table-responsive table-responsive-xl table-responsive-lg table-responsive-md table-responsive-sm">
                                                <table class="table table-striped">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">@lang('SL')</th>
                                                        <th scope="col">@lang('Date')</th>
                                                        <th scope="col">@lang('Ticket Number')</th>
                                                        <th scope="col">@lang('Subject')</th>
                                                        <th scope="col">@lang('Status')</th>
                                                        <th scope="col">@lang('Action')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($supports as $key => $support)
                                                        <tr>
                                                            <td data-label="@lang('SL')">{{ ++$key }}</td>
                                                            <td data-label="@lang('Date')">{{ $support->created_at->format('d M, Y h:i A') }}</td>
                                                            <td data-label="@lang('Ticket')">#{{ $support->ticket }}</td>
                                                            <td data-label="@lang('Subject')">{{ $support->subject }}</td>
                                                            <td data-label="@lang('Status')">
                                                                @if($support->status == 0)
                                                                    <span class="badge badge-primary">@lang('Open')</span>
                                                                @elseif($support->status == 1)
                                                                    <span class="badge badge-success "> @lang('Answered')</span>
                                                                @elseif($support->status == 2)
                                                                    <span class="badge badge-info"> @lang('Customer Replied')</span>
                                                                @elseif($support->status == 3)
                                                                    <span class="badge badge-danger ">@lang('Closed')</span>
                                                                @endif
                                                            </td>

                                                            <td data-label="@lang('Action')">
                                                                <a href="{{ route('user.message', $support->ticket) }}" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach



                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                {{$supports->links('partials.pagination')}}
                            </div>
                        </div>
                    </div>
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
