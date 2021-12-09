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
                                    <div class="col-md-8">

                                        <ul class="list-group text-center">
                                            @switch($type)
                                                @case('autosave')
                                                <p class="list-group-item">
                                                    @lang('You will be debited'):
                                                    <strong>{{formatter_money($data['amount'])}} </strong> {{$general->cur_text}}
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('On'):
                                                    <strong>{{ucfirst($data['how'])}}</strong> basis
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('In the'):
                                                    <strong>{{ucfirst($data['when'])}}'s </strong>
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('From'):
                                                    <strong>{{$data['start']}}</strong>
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('To'):
                                                    <strong>{{$data['end']}}</strong>
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('For'):
                                                    <strong>{{$reason}}</strong>
                                                </p>
                                                @break
                                                @case('vault')
                                                <p class="list-group-item">
                                                    @lang('You will lock'):
                                                    <strong>{{formatter_money($data['amount'])}} </strong> {{$general->cur_text}}
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('Until'):
                                                    <strong>{{$data['end']}}</strong>
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('For'):
                                                    <strong>{{$reason}}</strong>
                                                </p>
                                                @break
                                                @case('targetsave')
                                                <p class="list-group-item">
                                                    @lang('You set a target of saving'):
                                                    <strong>{{formatter_money($data['target'])}} </strong> {{$general->cur_text}}
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('You will be debited'):
                                                    <strong>{{formatter_money($data['amount'])}} </strong> {{$general->cur_text}}
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('On'):
                                                    <strong>{{ucfirst($data['how'])}}</strong> basis
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('In the'):
                                                    <strong>{{ucfirst($data['when'])}}'s </strong>
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('From'):
                                                    <strong>{{$data['start']}}</strong>
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('To'):
                                                    <strong>{{$data['end']}}</strong>
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('Or until you hit your target of'):
                                                    <strong>{{$data['target']}}</strong> {{$general->cur_text}}
                                                </p>
                                                <p class="list-group-item">
                                                    @lang('For'):
                                                    <strong>{{$reason}}</strong>
                                                </p>
                                                @break
                                            @endswitch
                                        </ul>
                                        <a href="add-card/{{$type}}/{{$trx}}" class="btn btn-custom2 py-3  btn-block"><i class="fa fa-credit-card"></i>@lang('Add card')</a>
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
