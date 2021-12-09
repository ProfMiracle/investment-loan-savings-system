<div class="col-md-7 col-lg-5 col-xl-4">
    <aside class="blog-sidebar">

        <div class="widget widget-post">
            <h6 class="title"><i class="flaticon-scroll"></i>@lang('Recent Posts')</h6>
            <ul>
                @foreach($recentBlog as $k=> $data)
                <li>
                    <a href="{{route('home.blog.details',[str_slug($data->value->title),$data->id])}}">
                        <div class="thumb">
                            <img src="{{get_image(config('constants.frontend.blog.post.path').'/thumb_'.$data->value->image)}}" alt="{{$data->value->title}}"  >
                        </div>
                        <div class="content">
                            <h6 class="subtitle">{{__(str_limit($data->value->title, 40))}} </h6>
                            <span>{{date('d M, Y', strtotime($data->created_at))}}</span>
                        </div>
                    </a>
                </li>
                @endforeach

            </ul>
        </div>
    </aside>
</div>
