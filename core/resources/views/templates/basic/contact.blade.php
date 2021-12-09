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



    <div class="contact-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-page">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="contact-form-area">
                                    <h3 class="section-title">{{__($contact->value->title)}}</h3>
                                    <p>{{__($contact->value->short_details)}}</p>
                                    <form method="post" action="">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input name="name" type="text" placeholder="@lang('Your Name')" class="form-control" value="{{old('name')}}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input name="phone" type="text" placeholder="@lang('Contact Number')" class="form-control" value="{{old('phone')}}" required>
                                            </div>

                                            <div class="col-md-6">
                                                <input name="email" type="text" placeholder="@lang('Enter E-Mail Address')" class="form-control" value="{{old('email')}}" required>
                                            </div>

                                            <div class="col-md-6">
                                                <input name="subject" type="text" placeholder="@lang('Write your subject')" class="form-control" value="{{old('subject')}}" required>
                                            </div>
                                        </div>
                                        <textarea name="message" wrap="off" placeholder="@lang('Write your message')" class="form-control" >{{old('message')}}</textarea>
                                        <input type="submit" value="@lang('Send message')" class="btn btn-default website-color  btn-lg mt-3">

                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="contact-social-area">
                                    <h3 class="section-title">@lang('Contact')</h3>
                                    <div class="mail-area">
                                        <span class="support">
                                            <i class="fas fa-phone"></i>
                                            <a href="javascript:void(0)">
                                                @php echo  $contact->value->contact_number @endphp
                                            </a>
                                        </span>

                                        <span class="support mt-1">
                                            <i class="fas fa-envelope"></i><a href="javascript:void(0)" >@php echo  $contact->value->email_address @endphp</a>
                                        </span>


                                        <span class="support mt-1"><i class="fas fa-location-arrow"></i><a href="javascript:void(0)">
                                                @php echo  $contact->value->contact_details @endphp</a>
                                        </span>

                                    </div>
                                    <h3 class="section-title">@lang('Follow Us')</h3>
                                    <ul class="social-links">
                                        @foreach($socials as $data)
                                            <li><a href="{{$data->value->url}}" target="_blank" title="{{$data->value->title}}">{!! $data->value->icon !!}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
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



    @include(activeTemplate().'partials.subscribe')


@endsection
