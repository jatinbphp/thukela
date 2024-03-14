<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('user.signIn');
Route::post('login',[HomeController::class, 'login'])->name('user.login');
Route::get('dashboard',[HomeController::class, 'dashboard'])->name('user.dashboard');
Route::get('transactions',[HomeController::class, 'transactions'])->name('user.transactions');
Route::get('notifications',[HomeController::class, 'notifications'])->name('user.notifications');
Route::get('contactUs',[HomeController::class, 'contactUs'])->name('user.contactus');
Route::post('sendContactUs',[HomeController::class, 'sendContactUs'])->name('user.sendContactUs');
Route::get('provisionalBill',[HomeController::class, 'provisionalBill'])->name('user.provisionalbill');
Route::get('logout',[HomeController::class, 'logout'])->name('user.logout');
