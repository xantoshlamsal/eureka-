<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\GlController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
Route::get('currency', [CurrencyController::class, 'create']);
Route::get('currency-list', [CurrencyController::class, 'index']);
Route::post('currency', [CurrencyController::class, 'store']);
Route::get('currency/gl-map', [CurrencyController::class, 'glmap']);
Route::post('currency-gls', [CurrencyController::class, 'getGlsFromCurrency']);

Route::get('gl', [GlController::class, 'index']);
Route::post('gl', [GlController::class, 'store']);

Route::get('test', [CurrencyController::class, 'test']);
});

