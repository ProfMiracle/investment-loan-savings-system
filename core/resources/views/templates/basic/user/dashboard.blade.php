@extends(activeTemplate() .'layouts.user')

@section('content')

    <div class="inner-banner-area">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="title"><span>@lang('Welcome,')</span> {{Auth::user()->username}} !</h3>
                </div>
                <div class="col-lg-6">
                    <div class="banner-form-group">
                        <div class="input-group">
                            <input type="text" name="text" class="form-control" id="referralURL" value="{{route('refer.register',[Auth::user()->username])}}" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text copytext" id="copyBoard" onclick="myFunction()"> <i class="fa fa-copy"></i> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="privacy-area pb-130">
        <div class="container">
            <div class="row mb-30-none">
                @foreach($authWallets as $data)

                <div class="col-lg-4 col-md-6 col-sm-8 mb-30">
                    <div class="privacy-item">
                        <h3 class="title">{{__(str_replace('_',' ',strtoupper($data->type)))}}</h3>
                        <span class="total-amount">{{$general->cur_sym}}{{formatter_money($data->balance)}}</span>
                        @if($data->type == 'deposit_wallet')
                        <a href="{{route('user.deposit.history')}}" class="privacy-btn">@lang('View Report')</a>
                        @elseif($data->type == 'interest_wallet')
                            <a href="{{route('user.referral')}}" class="privacy-btn">@lang('View Report')</a>
                        @endif
                    </div>
                </div>
                @endforeach

                <div class="col-lg-4 col-md-6 col-sm-8 mb-30">
                    <div class="privacy-item">
                        <h3 class="title">@lang('Total Invest')</h3>
                        <span class="total-amount">{{$general->cur_sym}}{{formatter_money($totalInvest)}}</span>
                        <a href="{{route('user.interest.log')}}" class="privacy-btn">@lang('View Report')</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8 mb-30">
                    <div class="privacy-item">
                        <h3 class="title">@lang("Total Withdraw")</h3>
                        <span class="total-amount">{{$general->cur_sym}}{{formatter_money($totalWithdraw)}}</span>
                        <a href="{{route('user.withdrawLog')}}" class="privacy-btn">@lang('View Report')</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8 mb-30">
                    <div class="privacy-item">
                        <h3 class="title">@lang('Total Deposit')</h3>
                        <span class="total-amount">{{$general->cur_sym}}{{formatter_money($totalDeposit)}}</span>
                        <a href="{{route('user.deposit.history')}}" class="privacy-btn">@lang('View Report')</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8 mb-30">
                    <div class="privacy-item">
                        <h3 class="title">@lang('Total Ticket')</h3>
                        <span class="total-amount">{{$general->cur_sym}}{{$totalTicket}}</span>
                        <a href="{{route('user.ticket')}}" class="privacy-btn">@lang('View Report')</a>
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
    <script>
        function myFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/
            document.execCommand("copy");
            var alertStatus = "{{$general->alert}}";
            if(alertStatus == '1'){
                iziToast.success({message:"Copied: "+copyText.value, position: "topRight"});
            }else if(alertStatus == '2'){
                toastr.success("Copied: " + copyText.value);
            }
        }
    </script>
@endsection
