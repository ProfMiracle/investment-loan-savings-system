@extends(activeTemplate() .'layouts.master')

@section('content')
    @include(activeTemplate().'partials.frontend-breadcrumb')

    <!-- ========Ticket-Section Starts Here ========-->
    <section class="ticket-section padding-bottom c-shape-wrapper">
        <div class="container">
            <div class="row justify-content-center mb-30-none mt-5">

                @php
                    $color = ['bg-1','bg-2','bg-7','bg-8'];
                @endphp

                @foreach($plans as $k => $data)
                    @php
                        $time_name = \App\TimeSetting::where('time', $data->times)->first();
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="ticket-item {{$color[$k]}}">
                            <h3 class="title">{{$data->name}}</h3>
                            <h6 class="sub-title" id="interest">{{$data->phrase}}</h6>
                            <ul>


                                <li>@lang('24/7Support')</li>
                                <li>@lang($data->descr)</li>

                            </ul>
                            @guest
                                <a href="{{route('user.login')}}" type="button" class="btn btn-success custom-success" >@lang('Please, Signin your account at first')</a>
                            @else
                            <a href="{{url('/savings/create/'.$data->type)}}" class="custom-button custom-button-color investButton">@lang('Start Saving')</a>
                            @endguest
                        </div>
                    </div>

                    @php
                        array_push($color, $color[$k]);
                    @endphp
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========Ticket-Section Ends Here ========-->

@endsection


@section('load-js')
@stop
@section('script')
@stop
