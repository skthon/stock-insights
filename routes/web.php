<?php

use App\Http\Controllers\CompanySummaryController;
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

Route::get('/', [CompanySummaryController::class, 'showForm'] );
Route::post('/company/history', [CompanySummaryController::class, 'submitForm']);
