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

    <div class="bg-light">
        <div class="container py-5 ">
            <div class="row">
                <div class="col-sm-8">

                        <div class="blog-post">
                            <div class="item-thumbs">
                                <img src="{{asset($data['image'])}}" alt="{{$data['title']}}"  >
                            </div>
                            <div class="blog-outer">
                                <div class="meta ">
                                    <span class="date mb-3">  {{date('d M Y', strtotime($post->created_at))}}</span>
                                </div><br>
                                <h2 class="blog-title ">{{__($post->value->title)}} </h2>

                                <p class="text-dark mt-4 text-left">{{$post->value->body}}</p>

                            </div>
                            <div class="blog-bottom">
                                <div class="social-icons text-center">
                                    <ul>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" data-toggle="tooltip" title="" data-original-title="Facebook"><i class="fab fa-facebook"></i></a></li>
                                        <li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}" data-toggle="tooltip" title="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary" data-toggle="tooltip" title="" data-original-title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>



                </div>
                @include(activeTemplate().'partials.recent-blog')
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
