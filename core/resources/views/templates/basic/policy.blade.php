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

    <div class="privacy-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-page main-page--style">
                        <div class="card-body my-3">
                            <p>@php echo $menu->value->body @endphp</p>
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
