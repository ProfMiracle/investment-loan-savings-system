
<!-- ========Header-Section Starts Here ========-->
<div class="account--section sign-up-section">
    <div class="container-fluid">
        <div class="account--area">
            <div class="account--thumb">
                <img src="{{asset('assets/templates/minimul/images/account/')}}/sign-up.png" alt="account">
            </div>
            <span class="cross-button">
                        <i class="flaticon-plus"></i>
                    </span>
            <div class="account--content">
                <h4 class="title">create your account</h4>
                <form class="account-form">
                    <div class="form-group">
                        <label class="fixlabel" for="name1">
                            <i class="fas fa-user"></i>
                        </label>
                        <input type="text" id="name1" name="name" placeholder="Your Full Name">
                    </div>
                    <div class="form-group">
                        <label class="fixlabel" for="email2">
                            <i class="fas fa-envelope-open-text"></i>
                        </label>
                        <input type="email" id="email2" name="email" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                        <label class="fixlabel" for="pass2">
                            <i class="fas fa-unlock"></i>
                        </label>
                        <input type="password" id="pass2" placeholder="Password">
                    </div>
                    <div class="form-group check-group">
                        <input id="check01" type="checkbox">
                        <label for="check01">I agree with all <a href="#0">Terms & Conditions</a></label>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="register now">
                    </div>
                    <div class="form-group">
                        Already you have an account in here?
                        <a href="#0" class="sign-up-button-two d-block">Sign in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="account--section sign-in-section">
    <div class="container-fluid">
        <div class="account--area">
            <div class="account--thumb">
                <img src="{{asset('assets/templates/minimul/images/account/')}}/sign-in.png" alt="account">
            </div>
            <span class="cross-button">
                        <i class="flaticon-plus"></i>
                    </span>
            <div class="account--content">
                <h4 class="title">@lang('Sign in your account')</h4>
                <form class="account-form" id="userLoginForm" onsubmit="loginUser(event)">
                    @csrf
                    <div class="form-group">
                        <label class="fixlabel" for="email1">
                            <i class="fas fa-envelope-open-text"></i>
                        </label>
                        {{--<input type="email" id="email1" name="email" placeholder="Your Email">--}}
                        <input type="text" name="username" placeholder="Username ...."
                               class="input-field-square"
                               value="{{ old('username') }}">
                        <p class="eml error"></p>

                    </div>
                    <div class="form-group">
                        <label class="fixlabel" for="pass1">
                            <i class="fas fa-unlock"></i>
                        </label>
                        {{--<input type="password" id="pass1" placeholder="Password">--}}

                        <input type="password" name="password" placeholder="Password"
                               class="input-field-square">
                        <p class="eml error"></p>

                    </div>
                    <div class="form-group check-group mr-3">
                        <input id="check03" type="checkbox">
                        <label for="check03">remember me</label>
                    </div>
                    <div class="form-group check-group">
                        <input id="check02" type="checkbox">
                        <label for="check02">
                            <a href="#0">Forget Password</a>
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="submit"  class="submit-form-btn" value="sign in">
                    </div>
                    <div class="form-group">
                        Don`t have on account yet?
                        <a href="#0" class="sign-in-button-two d-block">create account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ========Header-Section Ends Here ========-->
