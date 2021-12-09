<!-- ========Footer-Section Starts Here ========-->
<footer class="footer-top padding-top">
    <div class="footer-shape"></div>
    <div class="tree1">
        <img src="{{asset('assets/images/frontend/footer/tree1.png')}}" alt="footer">
    </div>
    <div class="tree2 wow slideInUp">
        <img src="{{asset('assets/images/frontend/footer/tree2.png')}}" alt="footer">
    </div>
    <div class="futa">
        <img src="{{asset('assets/images/frontend/footer/futa.png')}}" alt="footer">
    </div>
    <div class="futa two">
        <img src="{{asset('assets/images/frontend/footer/futa.png')}}" alt="footer">
    </div>
    <div class="coin-3">
        <img src="{{asset('assets/images/frontend/footer/coin1.png')}}" alt="footer">
    </div>
    <div class="coin-3 two">
        <img src="{{asset('assets/images/frontend/footer/coin1.png')}}" alt="footer">
    </div>
    <div class="coin-3 three">
        <img src="{{asset('assets/images/frontend/footer/coin1.png')}}" alt="footer">
    </div>
    <div class="coin-4">
        <img src="{{asset('assets/images/frontend/footer/coin1.png')}}" alt="footer">
    </div>
    <div class="coin-4 two">
        <img src="{{asset('assets/images/frontend/footer/coin1.png')}}" alt="footer">
    </div>
    <div class="coin-4 three">
        <img src="{{asset('assets/images/frontend/footer/coin1.png')}}" alt="footer">
    </div>
    <div class="coin-4 four">
        <img src="{{asset('assets/images/frontend/footer/coin1.png')}}" alt="footer">
    </div>
    <div class="star-2 two">
        <img src="{{asset('assets/images/frontend/animation/04.png')}}" alt="shape">
    </div>
    <div class="star-2 three">
        <img src="{{asset('assets/images/frontend/animation/04.png')}}" alt="shape">
    </div>
    <div class="container">
        <div class="footer-area">
            <div class="footer-widget widget-about">
                <h5 class="title">
                    <a href="{{url('/')}}">{{$general->sitename}}</a>
                </h5>
                <div class="content">

                    <p>@php echo  $contact->value->website_footer @endphp</p>
                    <ul class="social-icons">
                        @foreach($socials as $data)
                            <li><a href="{{$data->value->url}}" target="_blank"
                                   title="{{$data->value->title}}">@php echo $data->value->icon  @endphp</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="footer-widget widget-links">
                <h5 class="title">
                    company
                </h5>
                <div class="content">
                    <ul>
                        <li><a href="{{route('home')}}">@lang('Home')</a></li>
                        <li><a href="{{route('home.about')}}">@lang('About')</a></li>
                        <li><a href="{{route('home.faq')}}">@lang('FAQ')</a></li>
                        <li><a href="{{route('home.blog')}}">@lang('Blog')</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-widget widget-links">
                <h5 class="title">
                    useful link
                </h5>
                <div class="content">
                    <ul>
                        @foreach($company_policy as $policy)
                            <li>
                                <a href="{{route('home.policy',[$policy, str_slug($policy->value->title)])}}">
                                    {{__($policy->value->title)}}
                                </a>
                            </li>
                        @endforeach
                        <li><a href="{{route('home.rules')}}">@lang('Rules')</a></li>

                            <li><a href="{{route('home.contact')}}">@lang('Contact')</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-widget widget-about">
                <h5 class="title">
                    {{__(@$contact->data_values->title)}}
                </h5>
                <div class="content">
                    <ul class="addr">
                        <li>{{$contact->data_values->contact_details}}</li>
                        <li>
                            <a href="javascript:void(0)">Call Us Now  {{$contact->data_values->contact_number}}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"> {{$contact->data_values->email_address}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom padding-top light-color text-center pb-70">
            <p>&copy; {{date('Y')}} <a href="{{url('/')}}">{{$general->sitename}}</a>. @lang('All rights reserved')</p>
        </div>
    </div>
</footer>
<!-- ========Footer-Section Ends Here ========-->

@php
    if($plugins[1]->status == 1){
        $appKeyCode = $plugins[1]->shortcode->app_key->value;
        $twakTo = str_replace("{{app_key}}",$appKeyCode,$plugins[1]->script);
        echo $twakTo;
    }
@endphp
