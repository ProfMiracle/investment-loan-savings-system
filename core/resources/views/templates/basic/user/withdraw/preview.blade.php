@extends(activeTemplate() .'layouts.user')

@section('content')

    <div class="inner-banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="title"><span>@lang('Withdraw Preview')</span></h2>
                </div>

                <div class="col-lg-6">
                    <a href="{{route('user.withdraw.money')}}" class="float-right btn btn-success "><i class="fa fa-arrow-left"></i> @lang('Another Method')</a>
                </div>

            </div>
        </div>
    </div>



    <div class="privacy-area">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if(session()->has('danger'))
                        <div class="alert alert-danger">
                            {{ session()->get('danger') }}
                        </div>
                    @endif
                </div>
            </div>


            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                        @endforeach
                    @endif
                </div>


                    <div class="col-lg-10 col-md-10 mb-4">
                        <div class="card card-deposit">

                            <h3 class="text-center mt-3">@lang('Current Balance') : <strong>{{ formatter_money($withdraw->wallet->balance)}}  {{ $general->cur_text }}</strong></h3>


                            <div class="card-body card-body-deposit">

                                <div class="form-group">
                                    <label class="control-label">@lang('Request Amount') : </label>

                                    <div class="input-group">
                                        <input type="text" value="{{formatter_money($withdraw->amount )}}" readonly  class="form-control form-control-lg" placeholder="@lang('Enter Amount')">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text ">{{$general->cur_text }} </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">@lang('Withdrawal Charge') : </label>
                                    <div class="input-group">
                                        <input type="text" value="{{ formatter_money($withdraw->charge) }}" readonly   class="form-control form-control-lg" placeholder="@lang('Enter Amount')">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text ">{{ $general->cur_text}} </span>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group">
                                    <label class=" control-label">@lang('You Will Get') : </label>
                                    <div class="input-group">
                                        <input type="text" value="{{ formatter_money($withdraw->final_amount) }}" readonly class="form-control form-control-lg" placeholder="@lang('Enter  Amount')" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text ">{{ $withdraw->currency }} </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label class="control-label">@lang('Available Balance') : </label>
                                    <div class="input-group">
                                        <input type="text" value="{{formatter_money($withdraw->wallet->balance - ($withdraw->amount + $withdraw->charge))}}"  class="form-control form-control-lg" placeholder="@lang('Enter Amount')" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text ">{{ $general->cur_text }} </span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer">
                                <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                        <div class="form-group">
                                            <label for="a-trans"> {{__($withdraw->method->verify_image)}}</label>
                                            <input type="file" class="form-control" name="verify_image">
                                        </div>

                                    @foreach(json_decode($withdraw->detail) as $k=> $value)
                                        <div class="form-group">
                                            <label> {{str_replace('_',' ',$k)}} </label>
                                            <input type="text" name="{{$k}}" value=""  class="form-control " placeholder="" >
                                        </div>
                                    @endforeach


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success custom-success mt-4 text-center btn-lg">@lang('Confirm')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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

@endsection


@section('script')


@stop
