<!-- ========Newslater-Section Starts Here ========-->
<section class="newslater-section padding-bottom" id="subscribe">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-xl-6 col-lg-7">
                <div class="section-header left-style mb-md-5">
                    <h2 class="title">@lang("Don't Miss Any Update")</h2>
                </div>
                <form class="newslater-form" action="{{route('home.subscribe')}}" method="post">
                        @csrf
                    <div class="form-group">

                        <input type="email" name="email" placeholder="@lang('Subscribe your email')" required value="{{old('email')}}">
                        <button type="submit">
                            <i class="flaticon-send"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="newslater-thumb">
                    <img src="{{asset('assets/images/frontend/footer/contact02.png')}}" alt="contact">
                    <div class="mes wow slideInUp">
                        <img src="{{asset('assets/images/frontend/footer/contact03.png')}}" alt="contact">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ========Newslater-Section Ends Here ========-->


