@extends(activeTemplate() .'layouts.user')

@section('style')

@stop
@section('content')

    @include(activeTemplate().'partials.breadcrumb')
    <!-- ========User-Panel-Section Starte Here ========-->
    <section class="user-panel-section padding-bottom padding-top">
        <div class="container user-panel-container">
            <div class=" user-panel-tab">
                <div class="row">
                    @include(activeTemplate().'partials.sidebar')

                    <div class="col-lg-9" id="myvideo">
                        <div class="user-panel-header mb-60-80">
                            <div class="left d-sm-block d-none">
                                <h6 class="title">{{__($page_title)}}</h6>
                            </div>
                            <ul class="right">
                                <li>
                                    <a href="#0" id="fullScreen"><i class="flaticon-ui-2"></i></a>
                                    <a href="#0" id="exitScreen"><i class="flaticon-ui-1"></i></a>
                                </li>

                                <li>
                                    <a href="#0" class="log-out d-lg-none">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>

                                            <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div>


                        <div class="tab-area fullscreen-width">
                            <div class="tab-item active">

                                <div class="col-md-12">
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div>{{$error}}</div>
                                        @endforeach
                                    @endif
                                </div>


                                <form action="{{route('user.start.confirmsave')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="{{$type}}">
                                    @switch($type)
                                        @case('autosave')
                                            <div class="form-group">
                                                <label>@lang('How much do you want to save regularly?'):</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="Minimum: N100" required=""  value="" min="100">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text currency-addon addon-bg">NGN</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>@lang('How do you want to save?')</label>
                                                <div class="input-group">
                                                    <select name="how" id="" class="form-control form-control-lg" required>
                                                        <option value="daily">Daily</option>
                                                        <option value="weekly">Weekly</option>
                                                        <option value="monthly">Monthly</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('When do you want to start?')</label>
                                                <div class="input-group">
                                                    <input type="date" name="start" class="form-control form-control-lg" required value="{{{date('Y-m-d')}}}" min="{{{date('Y-m-d')}}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('When do you want to end?')</label>
                                                <div class="input-group">
                                                    <input type="date" name="end" class="form-control form-control-lg" required value="{{{date('Y-m-d')}}}" min="{{{date('Y-m-d')}}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('Choose a debit time!')</label>
                                                <div class="input-group">
                                                    <select name="when" id="" class="form-control form-control-lg" required>
                                                        <option value="morning">Morning</option>
                                                        <option value="afternoon">Afternoon</option>
                                                        <option value="evening">Evening</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>@lang('What are you saving for?')</label>
                                                <div class="input-group">
                                                    <select name="reason" id="" class="form-control form-control-lg" required>
                                                        @foreach($reasons as $reason)
                                                            <option value="{{$reason->id}}">{{$reason->reason}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @break
                                        @case('vault')
                                        <div class="form-group">
                                            <label>@lang('Give your saving a name?'):</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-lg"  name="name" placeholder="Something nice" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('How much do you want to lock?'):</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="Minimum: N10,000" required=""  value="" min="10000">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text currency-addon addon-bg">NGN</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('When do you want to end?')</label>
                                            <div class="input-group">
                                                <input type="date" name="end" class="form-control form-control-lg" required value="{{{date('Y-m-d')}}}" min="{{{date('Y-m-d')}}}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('Select payment method'):</label>
                                            <select name="method" id="" class="form-control">
                                                <option value="">--select payment method--</option>
                                                <option value="interest">Interest Wallet</option>
                                                <option value="deposit">Deposit Wallet</option>
                                                <option value="card">Card</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('What are you saving for?')</label>
                                            <div class="input-group">
                                                <select name="reason" id="" class="form-control form-control-lg" required>
                                                    @foreach($reasons as $reason)
                                                        <option value="{{$reason->id}}">{{$reason->reason}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @break
                                        @case('targetsave')
                                        <div class="form-group">
                                            <label>@lang('Give your target a name?'):</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-lg"  name="name" placeholder="Something nice" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('How much do you want to save in total?'):</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="target" placeholder="Minimum: N10,000" required=""  value="" min="10000" id="amount">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text currency-addon addon-bg">NGN</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('How do you want to save?')</label>
                                            <div class="input-group">
                                                <select name="how" id="how" class="form-control form-control-lg" required>
                                                    <option value="daily">Daily</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('When do you want to start?')</label>
                                            <div class="input-group">
                                                <input type="date" name="start" class="form-control form-control-lg" required value="{{{date('Y-m-d')}}}" id="start" min="{{{date('Y-m-d')}}}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('When do you want to end?')</label>
                                            <div class="input-group">
                                                <input type="date" name="end" class="form-control form-control-lg" required value="{{{date('Y-m-d')}}}" id="end" min="{{{date('Y-m-d')}}}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('How much do you want to save regularly?'):</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="You wil de debited this amount regularly" required=""  value="" id="interval">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text currency-addon addon-bg">NGN</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('Choose a debit time!')</label>
                                            <div class="input-group">
                                                <select name="when" id="" class="form-control form-control-lg" required>
                                                    <option value="">--select one--</option>
                                                    <option value="morning">Morning</option>
                                                    <option value="afternoon">Afternoon</option>
                                                    <option value="evening">Evening</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('What are you saving for?')</label>
                                            <div class="input-group">
                                                <select name="reason" id="" class="form-control form-control-lg" required>
                                                    @foreach($reasons as $reason)
                                                        <option value="{{$reason->id}}">{{$reason->reason}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @break
                                    @endswitch
                                    <button type="submit" class="btn-primary">&nbsp;&nbsp;&nbsp;Proceed</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========User-Panel-Section Ends Here ========-->

@endsection


@section('load-js')
    @if($type == 'targetsave')
    <script>
        function getSmallPaymentInInterval(){
            let start = new Date($('#start').val());
            let end = new Date($('#end').val());
            let how = $('#how').val();
            let amount = $('#amount').val()
            if (!amount){
                return;
            }
            let diff;
            let pay;
            //calculating the difference between start and stop dates
            const diffTime = Math.abs(end - start);
            if (how === 'daily')
            {
                diff = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            }else if(how === 'weekly')
            {
                diff = Math.ceil(diffTime / (1000 * 60 * 60 * 24 * 7));
            }else{
                diff = end.getMonth() - start.getMonth() + (12*(end.getFullYear() - start.getFullYear()));
            }
            //zero cannot divide any number so we make sure that it is  not zero insead its is one
            diff = diff === 0?1:diff;
            //now you divide the start amount by the date difference
            //then you'll know how much you can save to reach that goal
            pay = Math.round(parseInt(amount)/Math.round(diff));
            /**
             * populate the small payments input
             */
            $('#interval').val(pay)
            return pay;
        }
        $(function(){
            $('#amount').on('change', function () {
                getSmallPaymentInInterval();
            })
            $('#start').on('change', function () {
                getSmallPaymentInInterval();
            })
            $('#end').on('change', function () {
                getSmallPaymentInInterval();
            })
            $('#how').on('change', function () {
                getSmallPaymentInInterval();
            })
        })
    </script>
    @endif
@stop
