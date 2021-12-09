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
                                    <a href="{{route('user.ticket.open') }}" class="btn btn-custom float-right" data-toggle="tooltip" data-placement="top" title="@lang('Open New Support Ticket')">
                                        <i class="fa fa-plus"></i> @lang('Create')
                                    </a>
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

                                        {{$supports->links()}}
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
