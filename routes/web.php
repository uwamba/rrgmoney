<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\CashoutController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\SendController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FlateRateController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SafePayController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});
Route::post('sendmail',[EmailController::class,'sendEmail'])->name('sendEmail');
//Route::post('create',[App\Http\Controllers\CustomAuthController::class, 'create'])->name('create');
Route::post('create',[App\Http\Controllers\Auth\CustomAuthController::class, 'create'])->name('create');


Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('register', [App\Http\Controllers\Auth\CustomAuthController::class, 'index'])->name('register');
Route::post('validation', [App\Http\Controllers\Auth\CustomAuthController::class, 'validation'])->name('validation');
Auth::routes(['register' => false]);

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function(){
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);


Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('index');
     Route::get('customerList', [UserController::class, 'customerList'])->name('customerList');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::get('/newCustomer', [UserController::class, 'newCustomer'])->name('newCustomer');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::get('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::get('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');

    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::get('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

    Route::get('export/', [UserController::class, 'export'])->name('export');

});

Route::middleware('auth')->prefix('topup')->name('topup.')->group(function(){
    Route::get('/', [TopupController::class, 'index'])->name('index');
    Route::get('/admin_index', [TopupController::class, 'admin_index'])->name('admin_index');
    Route::get('/create', [TopupController::class, 'create'])->name('create');
    Route::get('/agentTopUpList', [TopupController::class, 'agentTopUpList'])->name('agentTopUpList');
    Route::get('/agentTopUp', [TopupController::class, 'agentTopUp'])->name('agentTopUp');
    Route::post('/agentTopUpNext', [TopupController::class, 'agentTopUpNext'])->name('agentTopUpNext');
    Route::get('/getData', [TopupController::class, 'getData'])->name('getData');
    Route::post('/store', [TopupController::class, 'store'])->name('store');
    Route::post('/agentStore', [TopupController::class, 'agentStore'])->name('agentStore');
    Route::post('/status', [TopupController::class, 'updateStatus'])->name('status');
    Route::get('/find', [TopupController::class, 'find'])->name('find');
});

Route::middleware('auth')->prefix('send')->name('send.')->group(function(){
    Route::get('/', [SendController::class, 'index'])->name('index');
    Route::get('/admin_index', [SendController::class, 'admin_index'])->name('admin_index');
    Route::get('/agent_transfer', [SendController::class, 'agent_transfer'])->name('agent_transfer');
    Route::get('/transfer', [SendController::class, 'transfer'])->name('transfer');
    Route::post('/approve', [SendController::class, 'approve'])->name('approve');
    Route::post('/transferNext', [SendController::class, 'transferNext'])->name('transferNext');
    Route::post('/storeTransfer', [SendController::class, 'storeTransfer'])->name('storeTransfer');
    Route::get('/getRate/{id}', [SendController::class, 'getRate'])->name('getRate');
    Route::get('/received', [SendController::class, 'received'])->name('received');
    Route::get('/create', [SendController::class, 'create'])->name('create');
    Route::post('/transferReceipt', [SendController::class, 'transferReceipt'])->name('transferReceipt');
    Route::get('/find', [SendController::class, 'find'])->name('find');
    Route::post('/store', [SendController::class, 'store'])->name('store');

});

Route::middleware('auth')->prefix('safe_pay')->name('safe_pay.')->group(function(){
    Route::get('/', [SafePayController::class, 'index'])->name('index');
    Route::get('/admin_index', [SafePayController::class, 'admin_index'])->name('admin_index');
    Route::get('/admin_history', [SafePayController::class, 'admin_history'])->name('admin_history');
    Route::get('/getRate/{id}', [SafePayController::class, 'getRate'])->name('getRate');
    Route::get('/received', [SafePayController::class, 'received'])->name('received');
    Route::get('/create', [SafePayController::class, 'create'])->name('create');
    Route::get('/find', [SafePayController::class, 'find'])->name('find');
    Route::post('/store', [SafePayController::class, 'store'])->name('store');
    Route::post('/status', [SafePayController::class, 'updateStatus'])->name('status');
});

Route::middleware('auth')->prefix('country')->name('country.')->group(function(){
    Route::get('/', [CountryController::class, 'index'])->name('index');
    Route::get('/create', [CountryController::class, 'create'])->name('create');
    Route::post('/store', [CountryController::class, 'store'])->name('store');
    Route::get('/delete/{country}', [CountryController::class, 'delete'])->name('destroy');

});
Route::middleware('auth')->prefix('currency')->name('currency.')->group(function(){
    Route::get('/', [CurrencyController::class, 'index'])->name('index');
    Route::get('/create', [CurrencyController::class, 'create'])->name('create');
    Route::post('/store', [CurrencyController::class, 'store'])->name('store');
    Route::get('/delete/{currency}', [CurrencyController::class, 'delete'])->name('destroy');

});
Route::middleware('auth')->prefix('flat_rate')->name('flat_rate.')->group(function(){
    Route::get('/', [FlateRateController::class, 'index'])->name('index');
    Route::get('/create/{currency}', [FlateRateController::class, 'create'])->name('create');
    Route::post('/store', [FlateRateController::class, 'store'])->name('store');
    Route::get('/delete/{flat_rate}', [FlateRateController::class, 'delete'])->name('destroy');

});

Route::middleware('auth')->prefix('stock')->name('stock.')->group(function(){
    Route::get('/', [StockController::class, 'index'])->name('index');
     Route::get('/adminList', [StockController::class, 'adminList'])->name('adminList');
    Route::get('/create', [StockController::class, 'create'])->name('create');
     Route::get('/adminCreate', [StockController::class, 'adminCreate'])->name('adminCreate');
    Route::post('/store', [StockController::class, 'store'])->name('store');
    Route::get('/delete/{stock}', [StockController::class, 'delete'])->name('destroy');
    Route::post('/status', [StockController::class, 'updateStatus'])->name('status');
    Route::post('/FinanceUpdateStatus', [StockController::class, 'FinanceUpdateStatus'])->name('FinanceUpdateStatus');
     Route::post('/approve', [StockController::class, 'approve'])->name('approve');
    Route::get('/admin_index', [StockController::class, 'admin_index'])->name('admin_index');
    Route::get('/financeApproval', [StockController::class, 'financeApproval'])->name('financeApproval');

});

Route::middleware('auth')->prefix('income')->name('income.')->group(function(){
    Route::get('/', [IncomeController::class, 'index'])->name('index');
    Route::get('/create', [IncomeController::class, 'create'])->name('create');
    Route::post('/store', [IncomeController::class, 'store'])->name('store');

});
Route::middleware('auth')->prefix('commission')->name('commission.')->group(function(){
    Route::get('/', [CommissionController::class, 'index'])->name('index');
    Route::get('/create', [CommissionController::class, 'create'])->name('create');
    Route::post('/store', [CommissionController::class, 'store'])->name('store');

});

Route::middleware('auth')->prefix('earning')->name('earning.')->group(function(){
    Route::get('/', [EarningController::class, 'index'])->name('index');
    Route::get('/create', [EarningController::class, 'create'])->name('create');
    Route::post('/store', [EarningController::class, 'store'])->name('store');
    Route::get('/delete/{earning}', [EarningController::class, 'delete'])->name('destroy');
    Route::post('/status', [EarningController::class, 'updateStatus'])->name('status');

});



Route::middleware('auth')->prefix('cashout')->name('cashout.')->group(function(){
    Route::get('/', [CashoutController::class, 'index'])->name('index');
     Route::get('/agentIndex', [CashoutController::class, 'agentIndex'])->name('agentIndex');
    Route::get('/create', [CashoutController::class, 'create'])->name('create');
     Route::get('/agentCreate', [CashoutController::class, 'agentCreate'])->name('agentCreate');
    Route::post('/store', [CashoutController::class, 'store'])->name('store');
    Route::get('/edit/{cashout}', [CashoutController::class, 'edit'])->name('edit');
    Route::post('/update/{cashout}', [CashoutController::class, 'update'])->name('update');
    Route::get('/admin_index', [CashoutController::class, 'admin_index'])->name('admin_index');
    Route::get('/delete/{cashout}', [CashoutController::class, 'delete'])->name('destroy');
    Route::post('/status', [CashoutController::class, 'updateStatus'])->name('status');
    Route::get('export/', [CashoutController::class, 'export'])->name('export');
    Route::post('comment/', [CashoutController::class, 'comment'])->name('comment');

});

Route::middleware('auth')->prefix('account')->name('account.')->group(function(){
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::get('/create', [AccountController::class, 'create'])->name('create');
    Route::post('/store', [AccountController::class, 'store'])->name('store');
    Route::get('/edit/{account}', [AccountController::class, 'edit'])->name('edit');
    Route::post('/update/{account}', [AccountController::class, 'update'])->name('update');
    Route::get('/delete/{account}', [AccountController::class, 'delete'])->name('destroy');

});




