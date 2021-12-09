<?php

Route::fallback(function () {
    return view('errors.404');
});

Route::get('clear', function () {
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
});



Route::get('/cron', 'CronController@cron');
Route::get('/savings_cron', 'SavingsCronController@cron');

Route::post('ipn/g101', 'Gateway\g101\ProcessController@ipn')->name('ipn.g101'); // paypal
Route::post('ipn/g102', 'Gateway\g102\ProcessController@ipn')->name('ipn.g102'); // Perfect Money
Route::post('ipn/g103', 'Gateway\g103\ProcessController@ipn')->name('ipn.g103'); // Stripe
Route::post('ipn/g104', 'Gateway\g104\ProcessController@ipn')->name('ipn.g104'); // Skrill
Route::post('ipn/g105', 'Gateway\g105\ProcessController@ipn')->name('ipn.g105'); // PayTM
Route::post('ipn/g106', 'Gateway\g106\ProcessController@ipn')->name('ipn.g106'); // Payeer
Route::post('ipn/g107', 'Gateway\g107\ProcessController@ipn')->name('ipn.g107'); // PayStack
Route::post('ipn/g108', 'Gateway\g108\ProcessController@ipn')->name('ipn.g108'); // VoguePay
Route::get('ipn/g109/{trx}/{type}', 'Gateway\g109\ProcessController@ipn')->name('ipn.g109'); //flutterwave

Route::post('ipn/g110', 'Gateway\g110\ProcessController@ipn')->name('ipn.g110'); // RozarPay
Route::post('ipn/g111', 'Gateway\g111\ProcessController@ipn')->name('ipn.g111'); // stripeJs
Route::post('ipn/g112', 'Gateway\g112\ProcessController@ipn')->name('ipn.g112'); //instamojo
Route::post('ipn/g113', 'Gateway\g113\ProcessController@ipn')->name('ipn.g113'); // 2checkout

Route::get('ipn/g501', 'Gateway\g501\ProcessController@ipn')->name('ipn.g501'); // Blockchain
Route::get('ipn/g502', 'Gateway\g502\ProcessController@ipn')->name('ipn.g502'); // Block.io
Route::post('ipn/g503', 'Gateway\g503\ProcessController@ipn')->name('ipn.g503'); // CoinPayment
Route::post('ipn/g504', 'Gateway\g504\ProcessController@ipn')->name('ipn.g504'); // CoinPayment ALL
Route::post('ipn/g505', 'Gateway\g505\ProcessController@ipn')->name('ipn.g505'); // Coingate
Route::post('ipn/g506', 'Gateway\g506\ProcessController@ipn')->name('ipn.g506'); // Coinbase commerce


Route::get('/', 'SiteController@home')->name('home');
Route::get('/change-lang/{lang}', 'SiteController@changeLang')->name('lang');


Route::post('/planCalculator', 'SiteController@planCalculator')->name('planCalculator');

Route::name('home.')->group(function () {
    Route::get('/faq', 'SiteController@faq')->name('faq');
    Route::get('/rules', 'SiteController@rules')->name('rules');
    Route::get('/info/{id}/{slug?}', 'SiteController@policyInfo')->name('policy');
    Route::get('/about', 'SiteController@about')->name('about');

    Route::get('/contact', 'SiteController@contact')->name('contact');
    Route::post('/contact', 'SiteController@contactSubmit')->name('contact.send');

    Route::get('/blog', 'SiteController@blog')->name('blog');
    Route::get('/blog/details/{slug?}/{id?}', 'SiteController@blogDetails')->name('blog.details');
    Route::get('/plan', 'SiteController@plan')->name('plan');

    Route::post('/subscribe', 'SiteController@subscribe')->name('subscribe');
});


Route::group(['middleware' => ['guest']], function () {
    Route::get('/register/{reference}', 'SiteController@register')->name('refer.register');
});


Route::name('user.')->prefix('user')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logoutGet')->name('logout');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify-code');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');

    Route::middleware('auth')->group(function () {
        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send_verify_code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify_email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify_sms');
        Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');


        Route::middleware('ckstatus')->group(function () {
            Route::get('dashboard', 'UserController@home')->name('home');

            Route::get('edit-profile', 'UserController@editProfile')->name('edit-profile');
            Route::post('edit-profile', 'UserController@submitProfile');

            Route::get('change-password', 'UserController@changePassword')->name('change-password');
            Route::post('change-password', 'UserController@submitPassword');

            // 2FA
            Route::get('security/two/step', 'UserController@twoFactorAuth')->name('twoFA');
            Route::post('g2fa-create', 'UserController@create2fa')->name('go2fa.create');
            Route::post('g2fa-disable', 'UserController@disable2fa')->name('disable.2fa');


            // User Support Ticket
            Route::get('supportTicket', 'UserController@supportTicket')->name('ticket');
            Route::get('openSupportTicket', 'UserController@openSupportTicket')->name('ticket.open');
            Route::post('openSupportTicket', 'UserController@storeSupportTicket')->name('ticket.store');
            Route::get('supportMessage/{ticket}', 'UserController@supportMessage')->name('message');
            Route::put('storeSupportMessage/{ticket}', 'UserController@supportMessageStore')->name('message.store');
            Route::get('ticketDownload/{ticket}', 'UserController@ticketDownload')->name('ticket.download');
            Route::post('ticketDelete', 'UserController@ticketDelete')->name('ticket.delete');


            // Deposit
            Route::get('deposit', 'Gateway\PaymentController@deposit')->name('deposit');
            Route::post('deposit', 'Gateway\PaymentController@deposit')->name('deposit');
            Route::post('deposit-insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
            Route::get('deposit-preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
            Route::get('deposit-confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');

            //transfer
            Route::get('transfer', 'Gateway\PaymentController@transfer')->name('transfer');
            Route::post('transfer', 'Gateway\PaymentController@transfer')->name('transfer');
            Route::post('transfer-insert', 'Gateway\PaymentController@transferInsert')->name('transfer.insert');
            Route::get('transfer-preview', 'Gateway\PaymentController@transferPreview')->name('transfer.preview');
            Route::get('transfer-confirm', 'Gateway\PaymentController@transferConfirm')->name('transfer.confirm');
            Route::get('transfer/history', 'UserController@transferHistory')->name('transfer.history');

            //manual deposit
            Route::get('manual/deposit-preview', 'Gateway\PaymentController@manualDepositPreview')->name('manualDeposit.preview');
            Route::get('manual/deposit', 'Gateway\PaymentController@manualDepositConfirm')->name('manualDeposit.confirm');
            Route::post('manual/deposit', 'Gateway\PaymentController@manualDepositUpdate')->name('manualDeposit.update');
            Route::get('deposit/history', 'UserController@depositHistory')->name('deposit.history');


            // Withdraw
            Route::get('/withdraw-money', 'UserController@withdrawMoney')->name('withdraw.money');
            Route::post('/withdraw-money', 'UserController@withdrawMoneyRequest')->name('withdraw.moneyReq');
            Route::get('/withdraw-preview', 'UserController@withdrawReqPreview')->name('withdraw.preview');
            Route::post('/withdraw-preview', 'UserController@withdrawReqSubmit')->name('withdraw.submit');
            Route::get('/withdraw-log', 'UserController@withdrawLog')->name('withdrawLog');

            // Transaction
            Route::get('transactions', 'UserController@transactions')->name('transactions');
            Route::get('interest/log', 'UserController@interestLog')->name('interest.log');

            Route::get('referral', 'UserController@refMy')->name('referral');
            Route::post('/plans', 'UserController@buyPlan')->name('buy.plan');
            Route::post('/savings', 'SavingsController@initiateFirstHandshake')->name('start.savings');

            //Savings routes
            Route::get('/savings/create/{plan}', [\App\Http\Controllers\SavingsController::class, 'sortPlanByType'])->name('sort.plan');

            //Loan system
            Route::get('loan/request', 'UserController@loanRequest')->name('loan');
            Route::post('loan/request', 'UserController@loanRequestAdd')->name('loan.request');
            Route::get('loan/history', 'UserController@loanHistory')->name('loan.history');
            Route::post('loan/payback', 'UserController@loanPaybackPost')->name('loan.payback');
            Route::get('loan/payback', 'UserController@loanPayback')->name('loan.payback');
        });
    });
});

//savings controller
Route::prefix('savings')->group(function (){
    Route::name('home.')->group(function (){
        Route::get('/', 'SavingsController@savings')->name('savings');
    });

    Route::post('ipn/g107', [\App\Http\Controllers\SavingsController::class, 'verifyPayment'])->name('verifypay'); // PayStack

    Route::name('user.')->middleware('auth')->group(function (){
        Route::middleware('ckstatus')->group(function (){
            Route::prefix('create')->group(function (){
                Route::get('{plan}', [\App\Http\Controllers\SavingsController::class, 'sortPlanByType']);
            });
            Route::name('start.')->group(function (){
                Route::post('confirmsave', [\App\Http\Controllers\SavingsController::class, 'confirmsave'])->name('confirmsave');
            });
            Route::prefix('add-card')->group(function (){
                Route::get('{plan}/{trx}', [\App\Http\Controllers\SavingsController::class, 'addCard']);
            });

            Route::prefix('history')->name('history.')->group(function (){
                Route::get('/', [\App\Http\Controllers\SavingsController::class, 'userGetHistory'])->name('all');
                Route::post('breaksave', [\App\Http\Controllers\SavingsController::class, 'breakSavings'])->name('breaksave');
            });
        });
    });
});

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');


        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        //refer
        Route::get('/referral', 'AdminController@refIndex')->name('referral.index');
        Route::post('/referral', 'AdminController@refStore')->name('store.refer');

        // General Setting
        Route::get('setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('setting', 'GeneralSettingController@update')->name('setting.update');

        // Language Manager
        Route::get('setting/language/manager', 'LanguageController@langManage')->name('setting.language-manage');
        Route::post('setting/language/manager', 'LanguageController@langStore')->name('setting.language-manage-store');
        Route::delete('setting/language-manage/{id}', 'LanguageController@langDel')->name('setting.language-manage-del');
        Route::get('setting/language-key/{id}', 'LanguageController@langEdit')->name('setting.language-key');
        Route::put('setting/key-update/{id}', 'LanguageController@langUpdate')->name('setting.key-update');
        Route::post('setting/language-manage-update/{id}', 'LanguageController@langUpdatepp')->name('setting.language-manage-update');
        Route::post('setting/language-import', 'LanguageController@langImport')->name('setting.import_lang');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo-icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo-icon');




        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email-template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email-template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email-template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email-template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email-template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email-template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email-template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email-template.sendTestMail');

        // SMS Setting
        Route::get('sms-template/global', 'SmsTemplateController@smsSetting')->name('sms-template.global');
        Route::post('sms-template/global', 'SmsTemplateController@smsSettingUpdate')->name('sms-template.global');
        Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms-template.index');
        Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms-template.edit');
        Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms-template.update');
        Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('email-template.sendTestSMS');

        // Plugin
        Route::get('plugin', 'PluginController@index')->name('plugin.index');
        Route::post('plugin/update/{id}', 'PluginController@update')->name('plugin.update');
        Route::post('plugin/activate', 'PluginController@activate')->name('plugin.activate');
        Route::post('plugin/deactivate', 'PluginController@deactivate')->name('plugin.deactivate');

        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
        Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
        Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
        Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.emailUnverified');
        Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.smsUnverified');
        Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
        Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
        Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
        Route::post('user/add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('users.addSubBalance');
        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.all');
        Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
        Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');
        Route::get('user/withdrawals/{id}', 'ManageUsersController@withdrawals')->name('users.withdrawals');
        Route::get('user/deposits/{id}', 'ManageUsersController@deposits')->name('users.deposits');
        Route::get('user/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');

        // Login History
        Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');
        Route::get('users/login/history', 'ManageUsersController@loginHistory')->name('users.login.history');

        // Subscriber
        Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::get('subscriber/send-email', 'SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/remove', 'SubscriberController@remove')->name('subscriber.remove');
        Route::post('subscriber/send-email', 'SubscriberController@sendEmail')->name('subscriber.sendEmail');

        // WITHDRAW SYSTEM
        Route::get('withdraw/pending', 'WithdrawalController@pending')->name('withdraw.pending');
        Route::get('withdraw/approved', 'WithdrawalController@approved')->name('withdraw.approved');
        Route::get('withdraw/rejected', 'WithdrawalController@rejected')->name('withdraw.rejected');
        Route::get('withdraw/log', 'WithdrawalController@log')->name('withdraw.log');
        Route::get('withdraw/{scope}/search', 'WithdrawalController@search')->name('withdraw.search');
        Route::post('withdraw/approve', 'WithdrawalController@approve')->name('withdraw.approve');
        Route::post('withdraw/reject', 'WithdrawalController@reject')->name('withdraw.reject');

        // Withdraw Method
        Route::get('withdraw/method/', 'WithdrawMethodController@methods')->name('withdraw.method.methods');
        Route::get('withdraw/method/new', 'WithdrawMethodController@create')->name('withdraw.method.create');
        Route::post('withdraw/method/store', 'WithdrawMethodController@store')->name('withdraw.method.store');
        Route::get('withdraw/method/edit/{id}', 'WithdrawMethodController@edit')->name('withdraw.method.edit');
        Route::post('withdraw/method/edit/{id}', 'WithdrawMethodController@update')->name('withdraw.method.update');
        Route::post('withdraw/method/activate', 'WithdrawMethodController@activate')->name('withdraw.method.activate');
        Route::post('withdraw/method/deactivate', 'WithdrawMethodController@deactivate')->name('withdraw.method.deactivate');

        // DEPOSIT SYSTEM
        Route::get('deposit', 'DepositController@deposit')->name('deposit.list');
        Route::get('deposit/pending', 'DepositController@pending')->name('deposit.pending');
        Route::get('deposit/rejected', 'DepositController@rejected')->name('deposit.rejected');
        Route::get('deposit/approved', 'DepositController@approved')->name('deposit.approved');
        Route::post('deposit/reject', 'DepositController@reject')->name('deposit.reject');
        Route::post('deposit/approve', 'DepositController@approve')->name('deposit.approve');
        Route::get('deposit/{scope}/search', 'DepositController@search')->name('deposit.search');

        // Manual Methods
        Route::get('deposit/manual-methods', 'ManualGatewayController@index')->name('deposit.manual.index');
        Route::get('deposit/manual-methods/new', 'ManualGatewayController@create')->name('deposit.manual.create');
        Route::post('deposit/manual-methods/new', 'ManualGatewayController@store')->name('deposit.manual.store');
        Route::get('deposit/manual-methods/edit/{id}', 'ManualGatewayController@edit')->name('deposit.manual.edit');
        Route::post('deposit/manual-methods/update/{id}', 'ManualGatewayController@update')->name('deposit.manual.update');
        Route::post('deposit/manual-methods/activate', 'ManualGatewayController@activate')->name('deposit.manual.activate');
        Route::post('deposit/manual-methods/deactivate', 'ManualGatewayController@deactivate')->name('deposit.manual.deactivate');

        // Deposit Gateway
        Route::get('deposit/gateway', 'GatewayController@index')->name('deposit.gateway.index');
        Route::get('deposit/gateway/edit/{code}', 'GatewayController@edit')->name('deposit.gateway.edit');
        Route::post('deposit/gateway/update/{code}', 'GatewayController@update')->name('deposit.gateway.update');
        Route::post('deposit/gateway/remove/{code}', 'GatewayController@remove')->name('deposit.gateway.remove');
        Route::post('deposit/gateway/activate', 'GatewayController@activate')->name('deposit.gateway.activate');
        Route::post('deposit/gateway/deactivate', 'GatewayController@deactivate')->name('deposit.gateway.deactivate');

        // Report
        Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');
        Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');


        // Admin Support
        Route::get('tickets-list', 'DashboardController@supportTicket')->name('ticket');
        Route::get('tickets-reply/{id}', 'DashboardController@ticketReply')->name('ticket.reply');
        Route::get('tickets-open', 'DashboardController@openSupportTicket')->name('open.ticket');
        Route::get('tickets-pending', 'DashboardController@pendingSupportTicket')->name('pending.ticket');
        Route::get('tickets-closed', 'DashboardController@closedSupportTicket')->name('closed.ticket');
        Route::put('ticketReplySend/{id}', 'DashboardController@ticketReplySend')->name('ticket.send');
        Route::get('ticketDownload/{ticket}', 'DashboardController@ticketDownload')->name('ticket.download');
        Route::post('ticketDelete', 'DashboardController@ticketDelete')->name('ticket.delete');


        // Contact Topic
        Route::get('contact-topic', 'ContactTopicController@index')->name('contact-topic');
        Route::get('contact-topic/data', 'ContactTopicController@getTopic')->name('get-topic');
        Route::post('contact-topic/store', 'ContactTopicController@storeTopic')->name('store.contact-topic');
        Route::post('contact-topic/update', 'ContactTopicController@updateTopic')->name('update.contact-topic');
        Route::post('contact-topic/delete', 'ContactTopicController@destroyTopic')->name('delete.contact-topic');



        // Time & Plan Controller
        Route::get('time-setting', 'TimeSettingController@index')->name('time-setting');
        Route::post('time-store', 'TimeSettingController@store')->name('time-store');
        Route::put('time-setting/{id}', 'TimeSettingController@update')->name('time-update');
        Route::delete('time-setting/{id}', 'TimeSettingController@destroy')->name('time-destroy');


        Route::get('plan-setting', 'PlanController@index')->name('plan-setting');
        Route::get('plan-setting/edit/{id}', 'PlanController@edit')->name('plan-edit');
        Route::get('plan-setting/create', 'PlanController@create')->name('plan-create');
        Route::get('plan-setting/create/saver', 'PlanController@createSaver')->name('plan-create-saver');
        Route::post('plan-setting/create', 'PlanController@store')->name('plan-store');
        Route::post('plan-setting/create/saver', 'PlanController@storeSaver')->name('plan-store-saver');
        Route::put('plan-setting/update/{id}', 'PlanController@update')->name('plan-update');


        //Loan system
        Route::get('loan/pending', 'LoanController@loanPending')->name('loan.pending');
        Route::post('loan/pending', 'LoanController@loanPendingAdd')->name('loan.pending');
        Route::get('loan/active', 'LoanController@loanActive')->name('loan.active');
        Route::get('loan/rejected', 'LoanController@loanRejected')->name('loan.rejected');
        Route::get('loan/manage', 'LoanController@loanManage')->name('loan.manage');
        Route::get('loan/interest', 'LoanController@loanInterest')->name('loan.interest');
        Route::post('loan/interest', 'LoanController@loanInterestAdd')->name('loan.interest');

        //Savings system
        Route::prefix('savings')->name('savings.')->group(function (){
            Route::name('autosave.')->prefix('autosave')->group(function (){
                Route::get('/pending', 'SavingsController@savingsPending')->name('pending');
                Route::get('/complete', 'SavingsController@savingsComplete')->name('complete');
                Route::get('/canceled', 'SavingsController@savingsComplete')->name('canceled');
            });
            Route::name('targetsave.')->prefix('targetsave')->group(function (){
                Route::get('/pending', 'SavingsController@savingsPending')->name('pending');
                Route::get('/complete', 'SavingsController@savingsComplete')->name('complete');
                Route::get('/canceled', 'SavingsController@savingsComplete')->name('canceled');
            });
            Route::name('vaultsave.')->prefix('vaultsave')->group(function (){
                Route::get('/pending', 'SavingsController@savingsPending')->name('pending');
                Route::get('/complete', 'SavingsController@savingsComplete')->name('complete');
                Route::get('/canceled', 'SavingsController@savingsComplete')->name('canceled');
            });
        });

        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {
            Route::post('store', 'FrontendController@store')->name('store');
            Route::post('remove', 'FrontendController@remove')->name('remove');
            Route::post('{id}/update', 'FrontendController@update')->name('update');

            // Blog
            Route::get('blog/', 'FrontendController@blogIndex')->name('blog.index');
            Route::get('blog/edit/{id}/{slug}', 'FrontendController@blogEdit')->name('blog.edit');
            Route::get('blog/new', 'FrontendController@blogNew')->name('blog.new');

            // SEO
            Route::get('seo', 'FrontendController@seoEdit')->name('seo.edit');

            // Social
            Route::get('social', 'FrontendController@socialIndex')->name('social.index');

            // Testimonial
            Route::get('testimonial', 'FrontendController@testimonialIndex')->name('testimonial.index');
            Route::get('testimonial/new', 'FrontendController@testimonialNew')->name('testimonial.new');
            Route::get('testimonial/edit/{id}', 'FrontendController@testimonialEdit')->name('testimonial.edit');

            // FAQ
            Route::get('faq', 'FrontendController@faqIndex')->name('faq.index');
            Route::get('faq/{id}/{slug}/edit', 'FrontendController@faqEdit')->name('faq.edit');
            Route::get('faq/new', 'FrontendController@faqNew')->name('faq.new');

            // RULE
            Route::get('rules', 'FrontendController@ruleIndex')->name('rules.index');
            Route::get('rules/{id}/edit', 'FrontendController@ruleEdit')->name('rules.edit');
            Route::get('rules/new', 'FrontendController@ruleNew')->name('rules.new');

            // Company policy
            Route::get('company_policy/', 'FrontendController@companyPolicy')->name('companyPolicy.index');
            Route::get('company_policy/{id}/{slug}/edit', 'FrontendController@companyPolicyEdit')->name('companyPolicy.edit');
            Route::get('company_policy/new', 'FrontendController@companyPolicyNew')->name('companyPolicy.new');


            // Manage About
            Route::get('about', 'FrontendController@sectionAbout')->name('about.edit');
            Route::post('about/{id}/update', 'FrontendController@sectionAboutUpdate')->name('about.update');

            // Manage About
            Route::get('homeContent', 'FrontendController@sectionHomeContent')->name('homeContent.edit');
            Route::post('homeContent/{id}/update', 'FrontendController@sectionHomeContentUpdate')->name('homeContent.update');



            // services
            Route::get('services', 'FrontendController@servicesIndex')->name('services.index');
            Route::get('services/new', 'FrontendController@servicesNew')->name('services.new');
            Route::get('services/edit/{id}', 'FrontendController@servicesEdit')->name('services.edit');

            // services
            Route::get('howToGetProfit', 'FrontendController@profitIndex')->name('profit.index');
            Route::get('howToGetProfit/new', 'FrontendController@profitNew')->name('profit.new');
            Route::get('howToGetProfit/edit/{id?}', 'FrontendController@profitEdit')->name('profit.edit');

            // services
            Route::get('feature', 'FrontendController@featureIndex')->name('feature.index');
            Route::get('feature/new', 'FrontendController@featureNew')->name('feature.new');
            Route::get('feature/edit/{id?}', 'FrontendController@featureEdit')->name('feature.edit');


            Route::get('breadcrumb-icon', 'FrontendController@logoIcon')->name('breadcrumb.logo-icon');
            Route::post('breadcrumb-icon', 'FrontendController@logoIconUpdate')->name('breadcrumb.logo-icon');




            Route::get('contact', 'FrontendController@sectionContact')->name('section.contact.edit');


        });
    });
});
