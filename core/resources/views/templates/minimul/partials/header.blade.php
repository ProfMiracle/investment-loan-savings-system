<div class="preloader">
    <div class="preloader-inner">
        <div class="preloader-icon">
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<a href="#0" class="scrollToTop">
    <i class="fas fa-angle-up"></i>
</a>
<div class="overlay"></div>
<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-top-area">
                <div class="left-side d-none d-sm-flex">
                    <ul class="social">
                        <li>
                            @foreach($socials as $data)
                                <a href="{{$data->value->url}}" target="_blank"
                                   title="{{$data->value->title}}">@php echo   $data->value->icon  @endphp</a>
                            @endforeach
                        </li>
                    </ul>
                    <p class="mail">
                        <i class="far fa-envelope"></i>{{@$contact->data_values->email_address}}
                    </p>
                </div>
                <div class="right-side">
                    <div class="form-group">
                        <i class="fas fa-globe"></i>
                        <select class="select-bar langSel">
                            <option value="en" @if(session('lang') == 'en') selected @endif><i
                                    class="flag-icon flag-icon-es"> </i>@lang('English')</option>
                            @foreach($language as $item)
                                <option value="{{$item->code}}" @if(session('lang') == $item->code) selected @endif><i
                                        class="flag-icon flag-icon-es"></i>{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @guest
                    <div class="account">
                        <a href="{{route('user.login')}}" class="text-white">
                            <i class="fas fa-user"></i>login
                        </a>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-area">
                <div class="logo">
                    <a href="{{url('/')}}">
                        <img src="{{get_image(config('constants.logoIcon.path') .'/logo.png')}}" alt="image">
                    </a>

                </div>
                <ul class="menu">

                    <li><a href="{{route('home')}}">@lang('Home')</a></li>
                    <li><a href="{{route('home.plan')}}">@lang('Plan')</a></li>
                    <li><a href="{{route('home.savings')}}">@lang('Savings')</a></li>
                    <li><a href="{{route('home.about')}}">@lang('About')</a></li>
                    <li><a href="{{route('home.faq')}}">@lang('FAQ')</a></li>
                    <li><a href="{{route('home.blog')}}">@lang('Blog')</a></li>
                    <li><a href="{{route('home.contact')}}">@lang('Contact')</a></li>


                    @auth
                        <li>
                            @if(Request::routeIs('user*'))
                                <a href="{{route('user.logout')}}" class="header-button bg-3">@lang('Logout')</a>
                            @else
                            <a href="{{route('user.home')}}" class="header-button bg-3">@lang('Dashboard')</a>
                            @endif
                        </li>
                    @else
                        <li>
                            <a href="{{route('user.register')}}" class="header-button bg-3">@lang('SIGN UP TODAY')</a>
                        </li>
                    @endif
                </ul>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</header>

