<div class="subscribe-area" id="subscribe">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8">
                <h3 class="section-title"> <span> @lang("Don't Miss Any Update")</span></h3>
            </div>
            <div class="col-lg-10">
                <form class="subscribe-form" action="{{route('home.subscribe')}}" method="post">
                    @csrf
                    <input type="email" name="email" placeholder="@lang('Subscribe your email')" required value="{{old('email')}}">
                    <input type="submit" class="btn-default website-color " value="@lang('Subscribe')">
                </form>
            </div>
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
