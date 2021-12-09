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


    <div class="faq-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-page">
                        <div class="accordion" id="accordionExample">
                            @foreach($faqs as $k=>$data)
                            <div class="card">
                                <div class="card-header" id="heading{{$data->id}}"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$data->id}}" aria-expanded="true" aria-controls="collapse{{$data->id}}"> {{__($data->value->title)}}</button></div>
                                <div id="collapse{{$data->id}}" class="collapse @if($k==0) show @endif" aria-labelledby="heading{{$data->id}}" data-parent="#accordionExample">
                                    <div class="card-body">@php echo $data->value->body @endphp</div>
                                </div>
                            </div>
                            @endforeach


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

    @include(activeTemplate().'partials.subscribe')

@endsection
