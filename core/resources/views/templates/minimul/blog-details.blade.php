@extends(activeTemplate() .'layouts.master')

@section('content')
    @include(activeTemplate().'partials.frontend-breadcrumb')
    <!-- ========blog-Section Starte Here ========-->
    <section class="blog-section padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center justify-content-lg-between">
                <div class="col-lg-7 col-xl-8 mb-5 mb-md-3 mb-lg-0">
                    <div class="post-item post-details">
                        <div class="post-thumb c-thumb">
                            <img src="{{asset($data['image'])}}" alt="{{$data['title']}}"  >
                        </div>
                        <div class="post-content">
                            <h5 class="title">
                                {{__($post->value->title)}}
                            </h5>
                            <ul class="meta-post justify-content-start">
                                <li>
                                    <a href="javascript:void(0)" class="cursor-text">
                                        <i class="fas fa-calendar-day"></i><span>{{date('d M Y', strtotime($post->created_at))}}</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="entry-content">
                                <p>{{$post->value->body}}</p>

                                <div class="author-area">
                                    <div class="author">
                                        <h6 class="author-cont">
                                            <a href="javascript:void(0)" class="cursor-text"><i class="fa fa-share"></i> @lang('Share')</a>
                                        </h6>
                                    </div>
                                    <ul class="social">
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" data-toggle="tooltip" title="" data-original-title="Facebook"><i class="fab fa-facebook"></i></a></li>
                                        <li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}" data-toggle="tooltip" title="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary" data-toggle="tooltip" title="" data-original-title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                @include(activeTemplate().'partials.recent-blog')
            </div>
        </div>
    </section>
    <!-- ========blog-Section Ends Here ========-->
@endsection


@section('load-js')
@stop
@section('script')


@stop
