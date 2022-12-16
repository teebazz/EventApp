<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\PagesController;
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
    return view('welcome');
})->name('/');
Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::post('login-action', [AuthController::class, 'loginUser'])->name('login-action');

Route::post('verify', [PagesController::class, 'verifyCode'])->name('verify');
Route::get('verify/{reference}', [PagesController::class, 'verifyDetail'])->name('verify_details');
Route::get('verify_attendee/{reference}', [PagesController::class, 'verifyAttendee'])->name('verify_attendee');

Route::group(['middleware' => 'auth'], function ()
{
    Route::get('dashboard', [PagesController::class, 'dashboard'])->name('dashboard');
    Route::get('attendees', [PagesController::class, 'attendees'])->name('attendees');
    Route::get('view-attendee/{reference}', [PagesController::class, 'viewInvite'])->name('view_attendee');
    Route::get('resend-invite/{reference}', [PagesController::class, 'resendnvite'])->name('resend_attendee');
    Route::post('create_attendee', [PagesController::class, 'createAttendee'])->name('create_attendee');
});

Route::get('logout', function ()
{
    auth()->logout();
    return redirect('/');
})->name('logout');