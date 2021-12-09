<section class="footer-area">
    <div class="container">
        <div class="footer-nav">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <nav class="navbar navbar-expand-lg p-0">
                        <div class="footer-menu">
                            <ul class="navbar-nav mr-auto">
                                <li><a href="{{route('home')}}">@lang('Home')</a></li>
                                <li><a href="{{route('home.about')}}">@lang('About')</a></li>
                                <li><a href="{{route('home.faq')}}">@lang('FAQ')</a></li>
                                <li><a href="{{route('home.blog')}}">@lang('Blog')</a></li>
                                <li><a href="{{route('home.contact')}}">@lang('Contact')</a></li>
                                @foreach($company_policy as $policy)
                                    <li>
                                        <a href="{{route('home.policy',[$policy, str_slug($policy->value->title)])}}">
                                            {{__($policy->value->title)}}
                                        </a>
                                    </li>
                                @endforeach
                                <li><a href="{{route('home.rules')}}">@lang('Rules')</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="{{url('/')}}" class="text-center">
                    <img src="{{get_image(config('constants.logoIcon.path') .'/logo.png')}}" class="logo-max" alt="logo">
                </a>
                <div class="footer-text mt-4">
                    <p>@php echo  $contact->value->website_footer @endphp</p>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="copiright">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <p>&copy; {{date('Y')}} {{__($general->sitename)}}. @lang('All rights reserved')</p>
            </div>
            <div class="col-lg-3">
                <ul class="social-links footer-social">
                    @foreach($socials as $data)
                        <li><a href="{{$data->value->url}}" target="_blank"
                               title="{{$data->value->title}}">@php echo $data->value->icon  @endphp</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>


@php
    if($plugins[1]->status == 1){
        $appKeyCode = $plugins[1]->shortcode->app_key->value;
        $twakTo = str_replace("{{app_key}}",$appKeyCode,$plugins[1]->script);
        echo $twakTo;
    }
@endphp
