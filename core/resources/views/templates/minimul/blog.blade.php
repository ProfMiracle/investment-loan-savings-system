@extends(activeTemplate() .'layouts.master')

@section('content')
    @include(activeTemplate().'partials.frontend-breadcrumb')

    <!-- ========blog-Section Starte Here ========-->
    <section class="blog-section padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center justify-content-lg-between">
                <div class="col-lg-7 col-xl-8 mb-5 mb-lg-0">
                    <div class="row mb-60-none">
                        @foreach($blogs as $k=> $data)
                        <div class="col-12">
                            <div class="post-item">
                                <div class="post-thumb c-thumb">
                                    <a href="{{route('home.blog.details',[str_slug($data->value->title),$data->id])}}">
                                        <img src="{{get_image(config('constants.frontend.blog.post.path').'/'.$data->value->image)}}" alt="{{$data->value->title}}">
                                    </a>
                                </div>
                                <div class="post-content">
                                    <h5 class="title">
                                        <a href="{{route('home.blog.details',[str_slug($data->value->title),$data->id])}}">
                                            {{__($data->value->title)}}
                                        </a>
                                    </h5>
                                    <ul class="meta-post justify-content-start">
                                        <li>
                                            <a href="javascript:void(0)" class="cursor-text">
                                                <i class="fas fa-calendar-day"></i><span>{{date('d-M-Y', strtotime($data->created_at))}}</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="entry-content">
                                        <p>{{str_limit(strip_tags($data->value->body),300)}}
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="blog-pagination">

                        {{$blogs->links()}}

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
