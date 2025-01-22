<?php

use App\Events\AlertDepositSuccessCrypto;
use App\Events\MyEvent;
use App\Events\Alert_Pusher;
use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Backend\DashboardandminController;
use App\Http\Controllers\Backend\DepositController;
use App\Http\Controllers\Backend\RecordserverController;
use App\Http\Controllers\Backend\WithdrawController as BackendWithdrawController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\DespositController;
use App\Http\Controllers\Frontend\EarningController;
use App\Http\Controllers\Frontend\HistoryController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\WithdrawController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;







Route::middleware('Auth')->group(function () {
    Route::get('login', function () {
        return view('Frontend.login');
    });
    Route::get('signup', [AuthenticatedController::class, 'singup_get'])->name('signup');
    Route::get('forget-password', [AuthenticatedController::class, 'forgetpassword'])->name('forgetpassword');
    Route::post('forget-password-send', [AuthenticatedController::class, 'forgetpassword_send'])->name('forgetpassword_send');
});

Route::controller(IndexController::class)->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/getLastTransactions', 'getLastTransactions')->name("getLastTransactions");
    Route::get('/getLastStats', 'getLastStats')->name("getLastStats");
});



Route::get('about', function () {
    return view('Frontend.about');
});
Route::get('news', function () {
    return view('Frontend.news');
});
Route::get('faq', function () {
    return view('Frontend.faq');
});
Route::get('rules', function () {
    return view('Frontend.rules');
});
Route::get('affiliates', function () {
    return view('Frontend.affiliates');
});

Route::controller(ContactController::class)->group(function () {
    Route::get('support', 'support')->name('support');
    Route::post('contact_send', 'contact_send')->name('contact_send');
});

Route::middleware('CheckAuthCustomer')->group(function () {

    Route::controller(IndexController::class)->group(function () {

        Route::get('dashboard', 'dashboard')->name('dashboard');

        Route::get('dashboard/referallinks', 'referrals')->name('referrals');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('dashboard/edit_account', 'edit_account')->name('edit_account');
        Route::post('edit_account_send', 'edit_account_send')->name("edit_account_send");
    });

    Route::controller(DespositController::class)->group(function () {

        Route::post('dashboard/deposit/checkout',  'depositcheckout')->name('deposit.checkout');

        Route::get('dashboard/deposit/checkouts', 'go_deposit_check')->name('go_deposit_check');

        Route::post('dashboard/deposit/send', 'deposit_send')->name('deposit_send');

        Route::get('dashboard/deposit_history', 'deposit_history')->name('deposit_history');

        Route::get('dashboard/deposit_list', 'deposit_list')->name('deposit_list');

        Route::get('dashboard/deposit', 'deposit')->name('deposit');
    });
    Route::controller(WithdrawController::class)->group(function () {

        Route::get('dashboard/withdraw', 'withdraw')->name('withdraw');
        Route::post('dashboard/withdraw/send', 'withdraw_send')->name('withdraw_send');
        Route::get('dashboard/withdraw_history', 'withdraw_history')->name('withdraw_history');
        Route::post('dashboard/withdraw_checkout_sent', 'withdraw_checkout_sent')->name('withdraw_checkout_sent');
        Route::get('dashboard/withdraw_confirm', 'withdraw_confirm')->name('withdraw_confirm');
    });
    Route::controller(EarningController::class)->group(function () {
        Route::get('dashboard/earning', 'earning_history')->name('earning_history');
    });
    Route::controller(HistoryController::class)->group(function () {
        Route::get('dashboard/historys', 'historys')->name('historys');
        Route::post('dashboard/filter', 'filter')->name('filter');
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::get('/createPayment', 'createPayment')->name('createPayment');
        Route::get('/setupPaymentWebhook', 'setupPaymentWebhook')->name('setupPaymentWebhook');

        Route::post('/paymentcoinbasecreate', 'paymentcoinbasecreate')->name('paymentcoinbasecreate');
    });
});


Route::get('/test-broadcast', function () {
    event(new Alert_Pusher("Register Successfully"));
    return 'send';
});
Route::get('/test-alertdepositsuccess', function () {
    // event(new EventsAlertDepositSuccessCrypto(37));
    event(new AlertDepositSuccessCrypto("Withdraw Success"));
    return 'send';
});

//Api

Route::controller(DepositController::class)->group(function () {
    Route::get('/checkstatusdeposit', 'checkstatusdeposit')->name('checkstatusdeposit');
});


Route::controller(RecordserverController::class)->group(function () {
    Route::post('/blockchain/websocket-error', 'websocketerror')->name('websocketerror');
});


Route::controller(PaymentController::class)->group(function () {

    Route::get('/deposit_failure', 'deposit_failure')->name('deposit_failure');

    Route::post('/handleCallbackPerfectMoney', 'handleCallbackPerfectMoney')->name('handleCallbackPerfectMoney');

    Route::get('/handleCallcoinbase', 'handleCallcoinbase')->name('handleCallcoinbase');

    // Update the route to accept both GET and POST requests
    Route::match(['get', 'post'], '/handlePayeerCallback', 'handlePayeerCallback')->name('handlePayeerCallback');




    Route::post('/blockchain/receiveTransactionBTC', 'receiveTransactionBTC')->name('receiveTransactionBTC');
    Route::post('/blockchain/receiveTransactionLTC', 'receiveTransactionLTC')->name('receiveTransactionLTC');
    Route::post('/blockchain/receiveTransactionBCH', 'receiveTransactionBCH')->name('receiveTransactionBCH');
    Route::post('/blockchain/receiveTransactionETH', 'receiveTransactionETH')->name('receiveTransactionETH');
    Route::post('/blockchain/receiveTransactionUSDT_BSC_BEP20', 'receiveTransactionUSDT_BSC_BEP20')->name('receiveTransactionUSDT_BSC_BEP20');
});




//Backend
Route::middleware('CheckAuthAdmin')->group(function () {
    Route::controller(DashboardandminController::class)->group(function () {
        Route::get('admin/dashboard', 'dashboard')->name('admin.dashboard');
    });

    Route::controller(DepositController::class)->group(function () {
        Route::get('admin/deposit', 'deposit')->name('admin/deposit');
        Route::get('admin/deposit/approved{id}', 'approved')->name('approved');
        Route::get('admin/deposit/pending/{id}', 'pending')->name('pending');
        Route::get('admin/deposit/delete_deposit{id}', 'delete_deposit')->name('delete_deposit');
    });
    Route::controller(BackendWithdrawController::class)->group(function () {
        Route::get('admin/withdraw', 'withdraw_admin')->name('withdraw_admin');
        Route::get('admin/complete/withdraw/{id}', 'withdraw_admin_complete')->name('withdraw_admin_complete');

        Route::get('admin/withdraw/pending/{id}', 'withdraw_admin_pending')->name('withdraw_admin_pending');
        Route::post('admin/withdraw/approved', 'approved_withdraw')->name('approved_withdraw');
        Route::get('admin/withdraw/delete{id}', 'delete_withdraw')->name('delete_withdraw');
        Route::get('admin/deposit/completewithdraw_edit/{id}', 'completewithdraw_edit')->name('completewithdraw_edit');
        Route::post('admin/deposit/approved_withdraw_update', 'approved_withdraw_update')->name('approved_withdraw_update');
    });
});


Route::controller(AuthenticatedController::class)->group(function () {
    Route::post('/logout', 'logout')->name("logout");
    Route::post('/login_auth', 'login')->name("login_auth");
    Route::post('/signup_auth', 'signup')->name("signup_auth");
    Route::get('/resetconfirm', 'resetconfirm')->name("resetconfirm");
});
