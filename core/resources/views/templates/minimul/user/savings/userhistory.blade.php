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
                                                    <th scope="col">@lang('Amount')</th>
                                                    <th scope="col">@lang('Start')</th>
                                                    <th scope="col">@lang('End')</th>
                                                    <th scope="col">@lang('Frequency')</th>
                                                    <th scope="col">@lang('Time')</th>
                                                    <th scope="col">@lang('Status')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($history) >0)
                                                    @foreach($history as $k=>$data)
                                                        <tr id="table">
                                                            <td data-label="@lang('Amount')">
                                                                <strong>{{formatter_money($data->amount)}} {{$general->cur_text}}</strong>
                                                            </td>
                                                            <td data-label="@lang('Start')">
                                                                <i class="fa fa-calendar"></i> {{date(' d M, Y ', strtotime($data->start))}}
                                                            </td>
                                                            <td data-label="@lang('End')">
                                                                <i class="fa fa-calendar"></i> {{date(' d M, Y ', strtotime($data->end))}}
                                                            </td>
                                                            <td data-label="@lang('Frequency')">{{$data->how}}</td>
                                                            <td data-label="@lang('Time')">{{$data->when}}</td>
                                                            <td data-label="@lang('Status')">
                                                                @if($data->status == 1)
                                                                    <button class="btn-sm btn-primary" id="running" data-amount="{{$data->amount}}" data-toggle="modal" data-target="#exampleModal" data-id="{{$data->id}}">Running</button>
                                                                @elseif($data->status == 2)
                                                                    <button disabled class="btn-warning">Stopped</button>
                                                                @else
                                                                    <button disabled class="btn-success">Completed</button>
                                                                @endif
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

                                        {{$history->links()}}
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="exampleModalLabel">Break Savings</strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>

                <form action="{{route('user.history.breaksave')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <strong>Heads up!</strong> You are about to break a running savings of <span id="amount"></span>. you will be charged a penalty fee as stipulated in the terms and conditions
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="id" class="edit-currency" value="" id="id">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="type" class="edit-currency" value="{{$type}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('load-js')
@stop
@section('script')
    <script>
        $(function(){
            let cur = "{{$general->cur_text}}";
            $('#table #running').mouseenter(function () {
                $(this).text('Break?')
                $(this).removeClass('btn-primary')
                $(this).addClass('btn-danger')
            });
            $('#table #running').mouseleave(function () {
                $(this).text('Running')
                $(this).removeClass('btn-danger')
                $(this).addClass('btn-primary')
            }).mouseleave();
            $('#table #running').on('click',function () {
                $('#amount').text($(this).data('amount') + cur)
                $('#id').val($(this).data('id'))
            });
        })
    </script>
@endsection
