
<!-- ========Blog-Section Starts Here ========-->
<section class="blog-section padding-bottom padding-top pos-rel">
    <div class="circle-2" data-paroller-factor="-0.30" data-paroller-factor-lg="0.60"
         data-paroller-type="foreground" data-paroller-direction="horizontal">
        <img src="{{asset('assets/images/frontend/animation/05.png')}}" alt="shape">
    </div>
    <div class="circle-2 four" data-paroller-factor="-0.1" data-paroller-factor-lg="0.30"
         data-paroller-type="foreground" data-paroller-direction="horizontal">
        <img src="{{asset('assets/images/frontend/animation/11.png')}}" alt="shape">
    </div>
    <div class="circle-1 three">
        <img src="{{asset('assets/images/frontend/animation/12.png')}}" alt="animation">
    </div>
    <div class="trop-3">
        <img src="{{asset('assets/images/frontend/animation/13.png')}}" alt="animation">
    </div>
    <div class="trop-4">
        <img src="{{asset('assets/images/frontend/animation/14.png')}}" alt="animation">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header">



                    <h2 class="title">{{$blogCaption->data_values->title}}</h2>
                    <p>{{$blogCaption->data_values->short_details}}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach($blogs as $k=> $data)
                <div class="col-md-6 col-xl-4 col-sm-10">
                    <div class="post-item">
                        <div class="post-thumb c-thumb">
                            <a href="{{route('home.blog.details',[str_slug($data->value->title),$data->id])}}">
                                <img src="{{get_image(config('constants.frontend.blog.post.path').'/'.$data->value->image)}}" alt="{{$data->value->title}}">
                            </a>
                        </div>
                        <div class="post-content">
                            <h5 class="title">
                                <a href="{{route('home.blog.details',[str_slug($data->value->title),$data->id])}}"> {{__(str_limit($data->value->title,30))}}</a>
                            </h5>
                            <ul class="meta-post">
                                <li>
                                    <a href="javascript:void(0)" class="cursor-text">
                                        <i class="fas fa-calendar-day"></i><span>{{date('d-M-Y', strtotime($data->created_at))}}</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="entry-content">
                                <p>{{str_limit(strip_tags($data->value->body),100)}}</p>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ========Blog-Section Ends Here ========-->
