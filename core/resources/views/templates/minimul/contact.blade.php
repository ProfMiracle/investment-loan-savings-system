@extends(activeTemplate() .'layouts.master')

@section('content')

    @include(activeTemplate().'partials.frontend-breadcrumb')

    <!-- ========Contact-Section Starts Here ========-->
    <section class="contact-section padding-bottom padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="contact-thumb">
                        <img src="{{asset('assets/templates/minimul/images/contact/contact01.png')}}" alt="faq">
                        <div class="mes1 wow slideInLeft">
                            <img src="{{asset('assets/templates/minimul/images/contact/mes1.png')}}" alt="faq">
                        </div>
                        <div class="mes2 wow slideInDown">
                            <img src="{{asset('assets/templates/minimul/images/contact/mes2.png')}}" alt="faq">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-header">
                        <span>{{__($contact->value->title)}}</span>
                        <h4 class="title">{{__($contact->value->short_details)}}</h4>
                    </div>
                        <form method="post" action="" class="contact-form">
                        <div class="form-group">
                            <input name="name" type="text" placeholder="@lang('Your Name')" value="{{old('name')}}" required>
                        </div>
                        <div class="form-group">
                            <input name="phone" type="text" placeholder="@lang('Contact Number')"  value="{{old('phone')}}" required>
                        </div>
                        <div class="form-group">
                            <input name="email" type="text" placeholder="@lang('Enter E-Mail Address')"  value="{{old('email')}}" required>
                        </div>
                        <div class="form-group">
                            <input name="subject" type="text" placeholder="@lang('Write your subject')"  value="{{old('subject')}}" required>
                        </div>


                        <div class="form-group w-100">
                            <textarea name="message" wrap="off" placeholder="@lang('Write your message')" >{{old('message')}}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="@lang('Send message')">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ========Contact-Section Ends Here ========-->

    <!-- ========Contact-Section Stars Here ========-->
    <div class="map-section padding-bottom">
        <div class="container mw-lg-100 p-lg-0">
            <div class="overview-area">
                <div class="overview-left">
                    <div class="address-area">
                        <div class="addr-item">
                            <div class="thumb">
                                <img src="{{asset('assets/templates/minimul/images/')}}/contact/addr1.png" alt="contact">
                            </div>
                            <div class="content">
                                <h6 class="title">@lang('Office Address')</h6>
                                <ul>
                                    <li>
                                        @php echo  $contact->value->contact_details @endphp
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="addr-item">
                            <div class="thumb">
                                <img src="{{asset('assets/templates/minimul/images/')}}/contact/addr2.png" alt="contact">
                            </div>
                            <div class="content">
                                <h6 class="title">@lang('Email Address')</h6>
                                <ul>
                                    <li>
                                        @php echo  $contact->value->email_address @endphp
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="addr-item">
                            <div class="thumb">
                                <img src="{{asset('assets/templates/minimul/images/')}}/contact/addr3.png" alt="contact">
                            </div>
                            <div class="content">
                                <h6 class="title">@lang('Contact Number')</h6>
                                <ul>
                                    <li>@php echo  $contact->value->contact_number @endphp
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="maps" id="data-maps" data-latitude="{{@$contact->value->latitude}}" data-longitude="{{@$contact->value->longitude}}"></div>
            </div>
        </div>
    </div>
    <!-- ========Contact-Section Ends Here ========-->

    @include(activeTemplate().'partials.subscribe')
@endsection

@section('load-js')
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyCo_pcAdFNbTDCAvMwAD19oRTuEmb9M50c"></script>
    <script src="{{asset('assets/templates/minimul/js/map.js')}}"></script>
@stop

