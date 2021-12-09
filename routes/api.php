<?php

use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\GlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('currency', [CurrencyController::class, 'index']);
Route::get('currency/{id}', [CurrencyController::class, 'show']);
Route::get('currency-gls/{id}', [CurrencyController::class, 'getGlsFromCurrencyId']);
Route::get('currency-gl-from-code/{code}', [CurrencyController::class, 'getCurrencyFromCurrencyCode']);
Route::get('gl-from-gl-code/{code}', [GlController::class, 'getGlFromGlCode']);
Route::get('gls/', [GlController::class, 'index']);
Route::get('gls/{id}', [GlController::class, 'show']);
Route::post('currency-map-gl', [CurrencyController::class, 'mapCurrencyToGl']);
