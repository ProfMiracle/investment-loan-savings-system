<div class="col-lg-3">
    <div class="user-area">
        <div class="remove-user d-lg-none">
            <i class="fas fa-times"></i>
        </div>
        <div class="user-item">
            <div class="user-thumb">
                <a href="#0">
                    <img src="{{get_image(config('constants.user.profile.path') .'/'. Auth::user()->image)}}" alt="user">
                </a>
            </div>
            <div class="user-content">
                <h6 class="title">@lang('Hello,') I am {{Auth::user()->username}}</h6>
                <p>Reg: {{date('M-d-Y',strtotime(Auth::user()->created_at))}}</p>
            </div>
        </div>
        <ul class="tab-menu">
            <li @if(Request::routeIs('user.home')) class="active" @endif>
                <a href="{{route('user.home')}}">@lang('Dashboard')</a>
            </li>

            <li @if(Request::routeIs('user.plan')) class="active" @endif>
                <a href="{{route('home.plan')}}">@lang('Investment Plans')</a></li>

            <li @if(Request::routeIs('user.savings*')) class="active" @endif>
                <a href="{{route('home.savings')}}">@lang('Saving Plans')</a></li>

            <li @if(Request::routeIs('user.history*')) class="active" @endif>
                <a href="{{route('user.history.all')}}">@lang('Saving History')</a></li>

            <li @if(Request::routeIs('user.interest.log')) class="active" @endif>
                <a  href="{{route('user.interest.log')}}">@lang('Return Interest Log')</a>
            </li>

            <li @if(Request::routeIs('user.deposit') || Request::routeIs('user.manualDeposit.preview') ||  Request::routeIs('user.manualDeposit.confirm') || Request::routeIs('user.deposit.preview')  ) class="active" @endif>
                <a  href="{{route('user.deposit')}}">@lang('Deposit Now')</a>
            </li>

            <li @if(Request::routeIs('user.deposit.history')) class="active" @endif>
                <a href="{{route('user.deposit.history')}}">@lang('Deposit History')</a>
            </li>


            <li @if(Request::routeIs('user.withdraw.money')) class="active" @endif>
                <a  href="{{route('user.withdraw.money')}}">@lang('Withdraw Now')</a>
            </li>

            <li @if(Request::routeIs('user.withdrawLog')) class="active" @endif>
                <a  href="{{route('user.withdrawLog')}}">@lang('Withdraw History')</a>
            </li>

            <li @if(Request::routeIs('user.transfer')) class="active" @endif>
                <a  href="{{route('user.transfer')}}">@lang('Transfer Now')</a>
            </li>

            <li @if(Request::routeIs('user.transfer.history')) class="active" @endif>
                <a href="{{route('user.transfer.history')}}">@lang('Transfer History')</a>
            </li>

            <li @if(Request::routeIs('user.loan.request')) class="active" @endif>
                <a href="{{route('user.loan.request')}}">@lang('Loan Request')</a>
            </li>

            <li @if(Request::routeIs('user.loan.history')) class="active" @endif>
                <a href="{{route('user.loan.history')}}">@lang('Loan History')</a>
            </li>

            <li @if(Request::routeIs('user.loan.payback')) class="active" @endif>
                <a href="{{route('user.loan.payback')}}">@lang('Loan Payback')</a>
            </li>

            <li @if(Request::routeIs('user.transactions')) class="active" @endif>
                <a  href="{{route('user.transactions')}}">@lang('Transaction History')</a>
            </li>

            <li @if(Request::routeIs('user.referral')) class="active" @endif>
                <a  href="{{route('user.referral')}}">@lang('Referral Statistic')</a>
            </li>

            <li @if(Request::routeIs('user.edit-profile')) class="active" @endif>
                <a  href="{{route('user.edit-profile')}}">@lang('Profile')</a>
            </li>

            <li @if(Request::routeIs('user.change-password')) class="active" @endif>
                <a  href="{{route('user.change-password')}}">@lang('Change Password')</a>
            </li>

            <li @if(Request::routeIs('user.ticket')) class="active" @endif>
                <a  href="{{route('user.ticket')}}">@lang('Support Ticket')</a>
            </li>

            <li @if(Request::routeIs('user.twoFA')) class="active" @endif>
                <a  href="{{route('user.twoFA')}}">@lang('2FA Security')</a>
            </li>

            <li>
                <a  href="{{route('user.logout')}}">@lang('Logout')</a>
            </li>



        </ul>
    </div>
</div>
