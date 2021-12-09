<!-- ========Sponsor-Section Starte Here ========-->
<div class="sponsor-section padding-bottom">
    <div class="container">
        <div class="sponsors">
            <h2 class="title" style="text-align: center;">We Accept</h2>
            <div class="owl-carousel owl-theme sponsor-slider">
                @foreach($weAccept ?? '' as $data)
                <div class="sponsor-thumb">
                    <a href="javascript:void(0)">
                        <img src="{{get_image(config('constants.deposit.gateway.path') .'/'. $data->image)}}" alt="{{$data->name}}">
                    </a>
                </div>
                @endforeach

            </div>
            <div class="owl-prev">
                <i class="fas fa-angle-left"></i>
            </div>
            <div class="owl-next">
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>
</div>
<!-- ========Sponsor-Section Ends Here ========-->

