
<section class="logo-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mon_wr owl-carousel">
                    @foreach($weAccept ?? '' as $data)
                        <div><img src="{{get_image(config('constants.deposit.gateway.path') .'/'. $data->image)}}" alt="{{$data->name}}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
