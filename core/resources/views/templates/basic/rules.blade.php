@extends(activeTemplate() .'layouts.master')

@section('content')
    <div class="inner-banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="title"><span>{{__($page_title)}}</span></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="rules-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-page main-page--style">

                        @foreach($rules as $k=>$data)
                        <div class="card-body my-3">
                            <p>
                                <span class="rulse-number">{{++$k}}</span>
                                @php echo $data->value->body @endphp
                            </p>
                        </div>
                        @endforeach
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

    @include(activeTemplate().'partials.subscribe')

@endsection
