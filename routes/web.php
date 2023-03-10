<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\EmailCallRestApiMiddleware;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group wCallRestSendgridhich
| contains the "web" middleware group. Now create something great!
|
*/

// Home Page
route::get('/', [DashboardController::class, 'index']);
// Call Ajax For Get DataTable Show History Sendmail
Route::post('fetch-mailhistory', [DashboardController::class, 'fetchMailHistory']);
// Call Rest API
Route::get('callrest-overview', [EmailController::class, 'CallRestSendgrid']);
Route::middleware([EmailCallRestApiMiddleware::class])->post('mailsending', [EmailController::class, 'CallRestApiMailer']);
